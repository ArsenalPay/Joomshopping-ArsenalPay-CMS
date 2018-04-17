<?php
/**
 * @version     1.1.0 16.04.2018
 * @author      ArsenalPay Dev. Team
 * @package     Jshopping
 * @copyright   Copyright (C) 2014-2018 ArsenalPay. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');

class pm_arsenalpay extends PaymentRoot {
	protected $callback;

	/**
	 * static
	 * Checkout Step3
	 *
	 * @param array $params    - entered params
	 * @param array $pmconfigs - configs
	 */
	function showPaymentForm($params, $pmconfigs) {
		include(dirname(__FILE__) . "/paymentform.php");
	}
/////////////////////////////////////////////////////////////

	/**
	 * Form parameters. Edit params payment in administrator.
	 * static
	 */
	function showAdminFormParams($params) {
		$this->loadLangFile();
		$array_params = array(
			'widget_id',
			'widget_key',
			'callback_key',
			'allowed_ip',
			'transaction_end_status',
			'transaction_pending_status',
			'transaction_cancel_status',
			'transaction_open_status',
			'transaction_other_status', // == reverse / reversal
			'transaction_refunded_status',
			'product_tax',
			'shipment_tax'
		);
		foreach ($array_params as $key) {
			if (!isset($params[$key])) {
				$params[$key] = '';
			}
		}
		$orders = JSFactory::getModel('orders', 'JshoppingModel'); //admin model
		$taxes  = $this->getArsenalpayTaxes();
		include(dirname(__FILE__) . "/adminparamsform.php");
	}

	function getArsenalpayTaxes() {
		return array(
			'none'   => _JSHOP_ARS_TAX_NONE,
			'vat0'   => _JSHOP_ARS_TAX_VAT0,
			'vat10'  => _JSHOP_ARS_TAX_VAT10,
			'vat18'  => _JSHOP_ARS_TAX_VAT18,
			'vat110' => _JSHOP_ARS_TAX_VAT110,
			'vat118' => _JSHOP_ARS_TAX_VAT118,
		);
	}

	/**
	 * Check Transaction - here is the handling of callback requests about payments
	 *
	 * @param array  $pmconfigs parameters
	 * @param object $order     order
	 * @param string $act       action
	 *
	 * @return array($rescode, $restext, $transaction, $transactiondata)
	 */
	function checkTransaction($pmconfigs, $order, $act) {
		$this->callback = $_POST;

		$REMOTE_ADDR = $_SERVER["REMOTE_ADDR"];
		$this->log("Request from " . $REMOTE_ADDR . " " . json_encode($this->callback));
		$IP_ALLOW = trim($pmconfigs['allowed_ip']);
		if (strlen($IP_ALLOW) > 0 && $IP_ALLOW != $REMOTE_ADDR) {
			$this->printCallbackResponse('ERR');

			return array(0, 'ERR_IP Order ID ' . $order->order_id);
		}

		if (!$this->checkParams($this->callback)) {
			$this->printCallbackResponse('ERR');

			return array(0, 'ERR_PARAM ' . $order->order_id);
		}
		$function = $this->callback['FUNCTION'];
		$KEY      = $pmconfigs['callback_key'];
		if (!($this->checkSign($this->callback, $KEY))) {
			$this->printCallbackResponse('ERR');

			return array(0, 'ERR_INVALID_SIGN ' . $order->order_id);
		}
		switch ($function) {
			case 'check':
				return $this->callbackCheck($order, $pmconfigs);
				break;

			case 'payment':
				return $this->callbackPayment($order, $pmconfigs);
				break;

			case 'cancel':
				return $this->callbackCancel($order, $pmconfigs);
				break;

			case 'cancelinit':
				return $this->callbackCancel($order, $pmconfigs);
				break;

			case 'refund':
				return $this->callbackRefund($order, $pmconfigs);
				break;

			case 'reverse':
				return $this->callbackReverse($order, $pmconfigs);
				break;

			case 'reversal':
				return $this->callbackReverse($order, $pmconfigs);
				break;

			case 'hold':
				return $this->callbackHold($order, $pmconfigs);
				break;

			default: {
				$this->printCallbackResponse('ERR');
				$this->log('Not supporting function - ' . $function);

				return array(0, 'ERR_FUNCTION. Order ID ' . $order->order_id);
			}
		}
	}


	private function callbackCancel($order, $pmconfigs) {
		$required_statuses = array(
			$pmconfigs['transaction_open_status'],
			$pmconfigs['transaction_pending_status'],
		);
		if (!in_array($order->order_status, $required_statuses)) {
			$comment = 'CANCEL_ERROR, Order #' . $order->order_id . ' was not checked.';
			$this->printCallbackResponse('ERR');

			return array(0, $comment);
		}

		$comment = 'Payment was cancelled';
		$this->printCallbackResponse('OK');

		return array(4, $comment, 'cancel');
	}

	private function callbackCheck($order, $pmconfigs) {
		$rejected_statuses = array(
			$pmconfigs['transaction_refunded_status'],
			$pmconfigs['transaction_cancel_status'],
			$pmconfigs['transaction_end_status'],
			$pmconfigs['transaction_other_status'],
		);

		if (in_array($order->order_status, $rejected_statuses)) {
			$comment = 'CHECK_ERROR, Order #' . $order->order_id . ' has rejected status(' . $order->order_status . ')';
			$this->printCallbackResponse('NO');

			return array(0, $comment);
		}
		$should_pay      = $this->getOrderTotal($order);
		$isCorrectAmount = ($this->callback['MERCH_TYPE'] == 0 && $should_pay == $this->callback['AMOUNT']) ||
		                   ($this->callback['MERCH_TYPE'] == 1 && $should_pay >= $this->callback['AMOUNT'] && $should_pay == $this->callback['AMOUNT_FULL']);

		if (!$isCorrectAmount) {
			$comment = 'Check error: Amounts do not match (request amount ' . $this->callback['AMOUNT'] . ' and ' . $this->getOrderTotal($order) . ')';
			$this->printCallbackResponse('NO');

			return array(0, $comment);
		}

		$fiscal = array();
		if (isset($this->callback['OFD']) && $this->callback['OFD'] == 1) {
			$fiscal = $this->prepareFiscal($order, $pmconfigs);
			if (!$fiscal) {
				$this->printCallbackResponse("ERR");
				$comment = "CHECK_ERROR, Order #" . $order->order_id . ": Fiscal document is empty";
				$this->log($comment);

				return array(0, $comment);
			}
		}
		$this->printCallbackResponse('YES', $fiscal);

		$comment = 'Waiting for payment confirmation';

		return array(2, $comment, $this->callback['STATUS']);
	}

	private function preparePhone($phone) {
		$phone = preg_replace('/[^0-9]/', '', $phone);
		if (strlen($phone) < 10) {
			return false;
		}
		if (strlen($phone) == 10) {
			return $phone;
		}
		if (strlen($phone) == 11) {
			return substr($phone, 1);
		}

		return false;

	}

	private function prepareFiscal($order, $pmconfigs) {
		if (!$order) {
			return array();
		}
		$order->getAllItems();
		$fiscal = array(
			"id"      => $this->callback['ID'],
			"type"    => "sell",
			"receipt" => [
				"attributes" => [
					"email" => $order->email
				],
				"items"      => array(),
			]

		);

		$phone = $this->preparePhone($order->phone);
		if ($phone) {
			$fiscal['receipt']['attributes']['phone'] = $phone;
		}

		$discount = $order->order_payment - $order->order_discount;
		if ($discount) {
			$discount = $discount / $order->order_subtotal;
		}

		$shipping  = $this->formatAmount($order->order_shipping, $order->currency_exchange);
		$total_sum = 0;
		$iterator  = 0;

		foreach ($order->items as $item) {
			$iterator ++;
			if ($iterator == count($order->items)) {
				$subtotal = $order->order_total - $shipping - $total_sum;
				$final    = round($subtotal / $item->product_quantity, 2);
			}
			else {
				$final    = round($item->product_item_price * (1 + $discount), 2);
				$subtotal = $final * $item->product_quantity;
			}
			$total_sum   += $subtotal;
			$fiscal_item = array(
				"name"     => $item->product_name,
				"price"    => $this->formatAmount($final, $order->currency_exchange),
				"quantity" => round($item->product_quantity, 2),
				"sum"      => $this->formatAmount($subtotal, $order->currency_exchange),

			);

			if (isset($pmconfigs['product_tax']) && strlen($pmconfigs['product_tax']) > 0) {
				$fiscal_item['tax'] = $pmconfigs['product_tax'];
			}

			$fiscal['receipt']['items'][] = $fiscal_item;
		}

		if ($shipping > 0) {
			$shipping_item = array(
				"name"     => "Доставка",
				"price"    => $shipping,
				"quantity" => 1,
				"sum"      => $shipping,
			);
			if (isset($pmconfigs['shipment_tax']) && strlen($pmconfigs['shipment_tax']) > 0) {
				$shipping_item['tax'] = $pmconfigs['shipment_tax'];
			}
			$fiscal['receipt']['items'][] = $shipping_item;
		}

		return $fiscal;
	}

	private function callbackPayment($order, $pmconfigs) {
		$required_statuses = array(
			$pmconfigs['transaction_open_status'],
			$pmconfigs['transaction_pending_status'],
		);

		if (!in_array($order->order_status, $required_statuses)) {
			$comment = 'PAYMENT_ERROR, Order #' . $order->order_id . ' was not checked.';
			$this->printCallbackResponse('ERR');

			return array(0, $comment);
		}
		$comment    = '';
		$should_pay = $this->getOrderTotal($order);
		if ($this->callback['MERCH_TYPE'] == 0 && $should_pay == $this->callback['AMOUNT']) {
			$comment = 'OK. Order ID ' . $order->order_id . '. Payed full amount.';
		}
        elseif ($this->callback['MERCH_TYPE'] == 1 && $should_pay >= $this->callback['AMOUNT'] && $should_pay == $this->callback['AMOUNT_FULL']) {
			$comment = 'OK. Order ID ' . $order->order_id . '. Payed amount is ' . $this->callback['AMOUNT'];
		}
		else {
			$this->printCallbackResponse('ERR');
			$comment = 'PAYMENT_ERROR: Amounts do not match (request amount ' . $this->callback['AMOUNT'] . ' and ' . $should_pay . ')';

			return array(0, $comment);
		}

		$cart = JSFactory::getModel('cart', 'jshop');
		$cart->load();
		$cart->getSum();
		$cart->clear();
		$this->printCallbackResponse('OK');

		return array(1, $comment, $this->callback['STATUS'], array('paid_amount' => $this->callback['AMOUNT']));
	}

	private function callbackHold($order, $pmconfigs) {
		$required_statuses = array(
			$pmconfigs['transaction_open_status'],
			$pmconfigs['transaction_pending_status'],
		);
		if (!in_array($order->order_status, $required_statuses)) {
			$comment = 'HOLD_ERROR, Order #' . $order->order_id . ' was not checked. Order has status (' . $order->order_status . ')';
			$this->printCallbackResponse('ERR');

			return array(0, $comment);
		}
		$should_pay      = $this->getOrderTotal($order);
		$isCorrectAmount = ($this->callback['MERCH_TYPE'] == 0 && $should_pay == $this->callback['AMOUNT']) ||
		                   ($this->callback['MERCH_TYPE'] == 1 && $should_pay >= $this->callback['AMOUNT'] && $should_pay == $this->callback['AMOUNT_FULL']);

		if (!$isCorrectAmount) {
			$comment = 'HOLD_ERROR: Amounts do not match (request amount ' . $this->callback['AMOUNT'] . ' and ' . $should_pay . ')';
			$this->printCallbackResponse('ERR');

			return array(0, $comment);
		}
		$comment = 'Payment was holden';
		$this->printCallbackResponse('OK');

		return array(5, $comment, $this->callback['STATUS']);
	}

	private function callbackRefund($order, $pmconfigs) {
		$required_statuses = array(
			$pmconfigs['transaction_refunded_status'],
			$pmconfigs['transaction_end_status'],
		);
		if (!in_array($order->order_status, $required_statuses)) {
			$comment = 'REFUND_ERROR, Order #' . $order->order_id . ' was not paid or refunded. Order has status (' . $order->order_status . ')';
			$this->printCallbackResponse('ERR');

			return array(0, $comment);
		}

		$total = $this->getOrderTotal($order) - $this->getOrderRefund($order);

		$isCorrectAmount = ($this->callback['MERCH_TYPE'] == 0 && $total >= $this->callback['AMOUNT']) ||
		                   ($this->callback['MERCH_TYPE'] == 1 && $total >= $this->callback['AMOUNT'] && $total >= $this->callback['AMOUNT_FULL']);

		if (!$isCorrectAmount) {
			$comment = "Refund error: Paid amount({$total}) < request refund amount({$this->callback['AMOUNT']})";
			$this->printCallbackResponse('ERR');

			return array(0, $comment);
		}
		$comment = "Payment was refund with amount = " . $this->callback['AMOUNT'];
		$this->printCallbackResponse('OK');

		return array(7, $comment, $this->callback['STATUS'], array('refund_amount' => $this->callback['AMOUNT']));
	}

	private function callbackReverse($order, $pmconfigs) {
		if ($order->order_status != $pmconfigs['transaction_end_status']) {
			$comment = 'REVERSE_ERROR, Order #' . $order->order_id . ' was not paid. Order has status (' . $order->order_status . ')';
			$this->printCallbackResponse('ERR');

			return array(0, $comment);
		}
		$refunded_amount = $this->getOrderRefund($order);
		$paid_amount     = $this->getOrderTotal($order);
		$total           = $paid_amount - $refunded_amount;
		$isCorrectAmount = ($this->callback['MERCH_TYPE'] == 0 && $total == $this->callback['AMOUNT']) ||
		                   ($this->callback['MERCH_TYPE'] == 1 && $total >= $this->callback['AMOUNT'] && $total == $this->callback['AMOUNT_FULL']);

		if (!$isCorrectAmount) {
			$comment = 'REVERSE_ERROR: Amounts do not match (request amount ' . $this->callback['AMOUNT'] . ' and ' . $total . ')';
			$this->log("Paid amount = {$paid_amount}, refunded amount = {$refunded_amount}, request amount = {$this->callback['AMOUNT']}");
			$this->printCallbackResponse('ERR');

			return array(0, $comment);
		}

		$comment = 'Payment was reversed';
		$this->printCallbackResponse('OK');

		return array(
			10,
			$comment,
			'reverse',
			array('refund_amount' => $this->callback['AMOUNT'])
		);
	}

	private function printCallbackResponse($msg, $fiscal = array()) {

		if (isset($this->callback['FORMAT']) && $this->callback['FORMAT'] == 'json') {
			$msg = array("response" => $msg);
			if ($fiscal && isset($this->callback['OFD']) && $this->callback['OFD'] == 1) {
				$msg['ofd'] = $fiscal;
			}
			$msg = json_encode($msg);
		}
		$this->log("Response: " . $msg);
		echo $msg;
	}

	private function checkParams($callback_params) {
		$required_keys = array
		(
			'ID',           /* Merchant identifier */
			'FUNCTION',     /* Type of request to which the response is received*/
			'RRN',          /* Transaction identifier */
			'PAYER',        /* Payer(customer) identifier */
			'AMOUNT',       /* Payment amount */
			'ACCOUNT',      /* Order number */
			'STATUS',       /* When /check/ - response for the order number checking, when
									// payment/ - response for status change.*/
			'DATETIME',     /* Date and time in ISO-8601 format, urlencoded.*/
			'SIGN',         /* Response sign  = md5(md5(ID).md(FUNCTION).md5(RRN).md5(PAYER).md5(request amount).
									// md5(ACCOUNT).md(STATUS).md5(PASSWORD)) */
		);

		/**
		 * Checking the absence of each parameter in the post request.
		 */
		foreach ($required_keys as $key) {
			if (empty($callback_params[$key]) || !array_key_exists($key, $callback_params)) {
				$this->log('Error in callback parameters ERR' . $key);

				return false;
			}
//			else {
//				$this->log(" $key=$callback_params[$key]");
//			}
		}
		if ($callback_params['FUNCTION'] != $callback_params['STATUS']) {
			$this->log("Error: FUNCTION ({$callback_params['FUNCTION']} not equal STATUS ({$callback_params['STATUS']})");

			return false;
		}

		return true;
	}

	private function checkSign($callback, $pass) {

		$validSign = ($callback['SIGN'] === md5(md5($callback['ID']) .
		                                        md5($callback['FUNCTION']) . md5($callback['RRN']) .
		                                        md5($callback['PAYER']) . md5($callback['AMOUNT']) . md5($callback['ACCOUNT']) .
		                                        md5($callback['STATUS']) . md5($pass))) ? true : false;

		return $validSign;
	}

	/*Checkout Step6 - show ArsenalPay payment widget*/
	function showEndForm($pmconfigs, $order) {
		$userId      = $order->user_id;
		$destination = $order->order_id;
		$amount      = $this->getOrderTotal($order);
		$widget      = $pmconfigs['widget_id'];
		$widget_key  = $pmconfigs['widget_key'];
		$nonce       = md5(microtime(true) . mt_rand(100000, 999999));
		$sign_param  = "$userId;$destination;$amount;$widget;$nonce";
		$widget_sign = hash_hmac('sha256', $sign_param, $widget_key);

		$checkout = JSFactory::getModel('checkoutOrder', 'jshop');
		$checkout->checkStep(6);
		// if $checkout->getSendEndForm() == 1 order will be canceled when user reload page (even if order was paid)
		$checkout->setSendEndForm(0);
		if ($order->order_status == $pmconfigs['transaction_end_status']) {
			?>
            <script>window.location = '<?php echo JURI::root() . "index.php?option=com_jshopping&controller=checkout&task=step7&act=return&js_paymentclass=pm_arsenalpay"; ?>';</script>
			<?php
		}
		?>
        <div id='arsenalpay-widget'></div>
        <script src='https://arsenalpay.ru/widget/script.js'></script>
        <script>
            var widget = new ArsenalpayWidget();
            widget.element = 'arsenalpay-widget';
            widget.widget = <?php echo $widget; ?>;
            widget.destination = '<?php echo $destination; ?>';
            widget.amount = '<?php echo $amount; ?>';
            widget.userId = '<?php echo $userId; ?>';
            widget.nonce = '<?php echo $nonce; ?>';
            widget.widgetSign = '<?php echo $widget_sign; ?>';
            widget.render();
        </script>
		<?php
	}

	private function getOrderTotal($order) {
		return $this->formatAmount($order->order_total, $order->currency_exchange);
	}

	private function formatAmount($amount, $currency_exchange = false) {
		if ($currency_exchange == false) {
			return round($amount, 2);
		}
		else {
			return round($amount / $currency_exchange, 2);
		}

	}

	private function log($msg) {
		saveToLog("paymentdata.log", $msg);
	}

	/**
	 * @param $order jshopOrder
	 *
	 * @return float|int
	 */
	private function getOrderRefund($order) {
		$transactions = $order->getListTransactions();
		if (!$transactions) {
			return 0;
		}
		$refunded_amount = 0;
		foreach ($transactions as $transaction) {
			foreach ($transaction->data as $data_obj) {
				if ($data_obj->key == 'refund_amount') {
					$refunded_amount += $this->formatAmount($data_obj->value, $order->currency_exchange);
				}

			}
		}

		return $refunded_amount;
	}

	function getUrlParams($pmconfigs) {
		$params                      = array();
		$params['order_id']          = $_POST['ACCOUNT'];
		$params['hash']              = "";
		$params['checkHash']         = 0;
		$params['checkReturnParams'] = 0;

		return $params;
	}

	function loadLangFile() {
		$lang = JFactory::getLanguage();
		if (!$lang_file = JPATH_SITE . '/components/com_jshopping/payments/pm_arsenalpay/lang/' . $lang->getTag() . '.pm_arsenalpay.php') {
			require_once JPATH_ROOT . '/components/com_jshopping/payments/arsenalpay/lang/' . 'en-GB.pm_arsenalpay.php';
		}
		else {
			require_once $lang_file;
		}
	}

}
