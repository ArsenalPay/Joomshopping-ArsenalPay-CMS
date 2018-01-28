<?php
/**
 * @version     1.0.3 22.11.2017
 * @author      ArsenalPay Dev. Team
 * @package     Jshopping
 * @copyright   Copyright (C) 2014-2017 ArsenalPay. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

class pm_arsenalpay extends PaymentRoot {
	/**
	 * static
	 * Checkout Step3
	 *
	 * @param array $params    - entered params
	 * @param array $pmconfigs - configs
	 */
	function showPaymentForm( $params, $pmconfigs ) {
		include( dirname( __FILE__ ) . "/paymentform.php" );
	}
/////////////////////////////////////////////////////////////

	/**
	 * Form parameters. Edit params payment in administrator.
	 * static
	 */
	function showAdminFormParams( $params ) {
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
		);
		foreach ( $array_params as $key ) {
			if ( ! isset( $params[$key] ) ) {
				$params[$key] = '';
			}
		}
		$orders = JSFactory::getModel( 'orders', 'JshoppingModel' ); //admin model
		include( dirname( __FILE__ ) . "/adminparamsform.php" );
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
	function checkTransaction( $pmconfigs, $order, $act ) {
		$callback_params = $_POST;

		$REMOTE_ADDR = $_SERVER["REMOTE_ADDR"];
		$IP_ALLOW = trim($pmconfigs['allowed_ip']);
		if(strlen($IP_ALLOW)>0 && $IP_ALLOW!=$REMOTE_ADDR) {
			echo 'ERR';
			return array(0, 'ERR_IP Order ID '.$order->order_id);
		}

		if ( ! $this->checkParams( $callback_params ) ) {
			echo 'ERR';

			return array( 0, 'ERR_PARAM ' . $order->order_id );
		}
		$function = $callback_params['FUNCTION'];
		$KEY      = $pmconfigs['callback_key'];
		if ( ! ( $this->checkSign( $callback_params, $KEY ) ) ) {
			echo 'ERR';

			return array( 0, 'ERR_INVALID_SIGN ' . $order->order_id );
		}
		switch ( $function ) {
			case 'check':
				return $this->callbackCheck( $callback_params, $order, $pmconfigs );
				break;

			case 'payment':
				return $this->callbackPayment( $callback_params, $order, $pmconfigs );
				break;

			case 'cancel':
				return $this->callbackCancel( $callback_params, $order, $pmconfigs );
				break;

			case 'cancelinit':
				return $this->callbackCancel( $callback_params, $order, $pmconfigs );
				break;

			case 'refund':
				return $this->callbackRefund( $callback_params, $order, $pmconfigs );
				break;

			case 'reverse':
				return $this->callbackReverse( $callback_params, $order, $pmconfigs );
				break;

			case 'reversal':
				return $this->callbackReverse( $callback_params, $order, $pmconfigs );
				break;

			case 'hold':
				return $this->callbackHold( $callback_params, $order, $pmconfigs );
				break;

			default: {
				echo 'ERR';
				$this->log( 'Not supporting function - ' . $function );

				return array( 0, 'ERR_FUNCTION. Order ID ' . $order->order_id );
			}
		}
	}


	private function callbackCancel( $callback_params, $order, $pmconfigs ) {
		$required_statuses = array(
			$pmconfigs['transaction_open_status'],
			$pmconfigs['transaction_pending_status'],
		);
		if ( ! in_array( $order->order_status, $required_statuses ) ) {
			$comment = 'CANCEL_ERROR, Order #' . $order->order_id . ' was not checked.';
			echo 'ERR';

			return array( 0, $comment );
		}

		$comment = 'Payment was cancelled';
		echo 'OK';

		return array( 4, $comment, 'cancel' );
	}

	private function callbackCheck( $callback_params, $order, $pmconfigs ) {
		$rejected_statuses = array(
			$pmconfigs['transaction_refunded_status'],
			$pmconfigs['transaction_cancel_status'],
			$pmconfigs['transaction_end_status'],
			$pmconfigs['transaction_other_status'],
		);

		if ( in_array( $order->order_status, $rejected_statuses ) ) {
			$comment = 'CHECK_ERROR, Order #' . $order->order_id . ' has rejected status(' . $order->order_status . ')';
			echo 'NO';

			return array( 0, $comment );
		}
		$should_pay      = $this->getAmount( $order );
		$isCorrectAmount = ( $callback_params['MERCH_TYPE'] == 0 && $should_pay == $callback_params['AMOUNT'] ) ||
		                   ( $callback_params['MERCH_TYPE'] == 1 && $should_pay >= $callback_params['AMOUNT'] && $should_pay == $callback_params['AMOUNT_FULL'] );

		if ( ! $isCorrectAmount ) {
			$comment = 'Check error: Amounts do not match (request amount ' . $callback_params['AMOUNT'] . ' and ' . $this->getAmount( $order ) . ')';
			echo 'NO';

			return array( 0, $comment );
		}
		echo 'YES';

		$comment = 'Waiting for payment confirmation';

		return array( 2, $comment, $callback_params['STATUS'] );
	}

	private function callbackPayment( $callback_params, $order, $pmconfigs ) {
		$required_statuses = array(
			$pmconfigs['transaction_open_status'],
			$pmconfigs['transaction_pending_status'],
		);

		if ( ! in_array( $order->order_status, $required_statuses ) ) {
			$comment = 'PAYMENT_ERROR, Order #' . $order->order_id . ' was not checked.';
			echo 'ERR';

			return array( 0, $comment );
		}
		$comment    = '';
		$should_pay = $this->getAmount( $order );
		if ( $callback_params['MERCH_TYPE'] == 0 && $should_pay == $callback_params['AMOUNT'] ) {
			$comment = 'OK. Order ID ' . $order->order_id . '. Payed full amount.';
		}
        elseif ( $callback_params['MERCH_TYPE'] == 1 && $should_pay >= $callback_params['AMOUNT'] && $should_pay == $callback_params['AMOUNT_FULL'] ) {
			$comment = 'OK. Order ID ' . $order->order_id . '. Payed amount is ' . $callback_params['AMOUNT'];
		}
		else {
			echo 'ERR';
			$comment = 'PAYMENT_ERROR: Amounts do not match (request amount ' . $callback_params['AMOUNT'] . ' and ' . $should_pay . ')';

			return array( 0, $comment );
		}

		$cart = JSFactory::getModel( 'cart', 'jshop' );
		$cart->load();
		$cart->getSum();
		$cart->clear();
		echo 'OK';

		return array( 1, $comment, $callback_params['STATUS'], array( 'paid_amount' => $callback_params['AMOUNT'] ) );
	}

	private function callbackHold( $callback_params, $order, $pmconfigs ) {
		$required_statuses = array(
			$pmconfigs['transaction_open_status'],
			$pmconfigs['transaction_pending_status'],
		);
		if ( ! in_array( $order->order_status, $required_statuses ) ) {
			$comment = 'HOLD_ERROR, Order #' . $order->order_id . ' was not checked. Order has status (' . $order->order_status . ')';
			echo 'ERR';

			return array( 0, $comment );
		}
		$should_pay      = $this->getAmount( $order );
		$isCorrectAmount = ( $callback_params['MERCH_TYPE'] == 0 && $should_pay == $callback_params['AMOUNT'] ) ||
		                   ( $callback_params['MERCH_TYPE'] == 1 && $should_pay >= $callback_params['AMOUNT'] && $should_pay == $callback_params['AMOUNT_FULL'] );

		if ( ! $isCorrectAmount ) {
			$comment = 'HOLD_ERROR: Amounts do not match (request amount ' . $callback_params['AMOUNT'] . ' and ' . $should_pay . ')';
			echo 'ERR';

			return array( 0, $comment );
		}
		$comment = 'Payment was holden';
		echo 'OK';

		return array( 5, $comment, $callback_params['STATUS'] );
	}

	private function callbackRefund( $callback_params, $order, $pmconfigs ) {
		$required_statuses = array(
			$pmconfigs['transaction_refunded_status'],
			$pmconfigs['transaction_end_status'],
		);
		if ( ! in_array( $order->order_status, $required_statuses ) ) {
			$comment = 'REFUND_ERROR, Order #' . $order->order_id . ' was not paid or refunded. Order has status (' . $order->order_status . ')';
			echo 'ERR';

			return array( 0, $comment );
		}

		$total = $this->getAmount( $order ) - $this->getRefundedAmount( $order );

		$isCorrectAmount = ( $callback_params['MERCH_TYPE'] == 0 && $total >= $callback_params['AMOUNT'] ) ||
		                   ( $callback_params['MERCH_TYPE'] == 1 && $total >= $callback_params['AMOUNT'] && $total >= $callback_params['AMOUNT_FULL'] );

		if ( ! $isCorrectAmount ) {
			$comment = "Refund error: Paid amount({$total}) < request refund amount({$callback_params['AMOUNT']})";
			echo 'ERR';

			return array( 0, $comment );
		}
		$comment = "Payment was refund with amount = " . $callback_params['AMOUNT'];
		echo 'OK';

		return array( 7, $comment, $callback_params['STATUS'], array( 'refund_amount' => $callback_params['AMOUNT'] ) );
	}

	private function callbackReverse( $callback_params, $order, $pmconfigs ) {
		if ( $order->order_status != $pmconfigs['transaction_end_status'] ) {
			$comment = 'REVERSE_ERROR, Order #' . $order->order_id . ' was not paid. Order has status (' . $order->order_status . ')';
			echo 'ERR';

			return array( 0, $comment );
		}
		$refunded_amount = $this->getRefundedAmount( $order );
		$paid_amount     = $this->getAmount( $order );
		$total           = $paid_amount - $refunded_amount;
		$isCorrectAmount = ( $callback_params['MERCH_TYPE'] == 0 && $total == $callback_params['AMOUNT'] ) ||
		                   ( $callback_params['MERCH_TYPE'] == 1 && $total >= $callback_params['AMOUNT'] && $total == $callback_params['AMOUNT_FULL'] );

		if ( ! $isCorrectAmount ) {
			$comment = 'REVERSE_ERROR: Amounts do not match (request amount ' . $callback_params['AMOUNT'] . ' and ' . $total . ')';
			$this->log( "Paid amount = {$paid_amount}, refunded amount = {$refunded_amount}, request amount = {$callback_params['AMOUNT']}" );
			echo 'ERR';

			return array( 0, $comment );
		}

		$comment = 'Payment was reversed';
		echo 'OK';

		return array(
			10,
			$comment,
			'reverse',
			array( 'refund_amount' => $callback_params['AMOUNT'] )
		);
	}

	private function checkParams( $callback_params ) {
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
		foreach ( $required_keys as $key ) {
			if ( empty( $callback_params[$key] ) || ! array_key_exists( $key, $callback_params ) ) {
				$this->log( 'Error in callback parameters ERR' . $key );

				return false;
			}
			else {
				$this->log( " $key=$callback_params[$key]" );
			}
		}
		if ( $callback_params['FUNCTION'] != $callback_params['STATUS'] ) {
			$this->log( "Error: FUNCTION ({$callback_params['FUNCTION']} not equal STATUS ({$callback_params['STATUS']})" );

			return false;
		}

		return true;
	}

	private function checkSign( $callback, $pass ) {

		$validSign = ( $callback['SIGN'] === md5( md5( $callback['ID'] ) .
		                                          md5( $callback['FUNCTION'] ) . md5( $callback['RRN'] ) .
		                                          md5( $callback['PAYER'] ) . md5( $callback['AMOUNT'] ) . md5( $callback['ACCOUNT'] ) .
		                                          md5( $callback['STATUS'] ) . md5( $pass ) ) ) ? true : false;

		return $validSign;
	}

	/*Checkout Step6 - show ArsenalPay payment widget*/
	function showEndForm( $pmconfigs, $order ) {
		$userId      = $order->user_id;
		$destination = $order->order_id;
		$amount      = $this->getAmount($order);
		$widget      = $pmconfigs['widget_id'];
		$widget_key  = $pmconfigs['widget_key'];
		$nonce       = md5( microtime( true ) . mt_rand( 100000, 999999 ) );
		$sign_param  = "$userId;$destination;$amount;$widget;$nonce";
		$widget_sign = hash_hmac( 'sha256', $sign_param, $widget_key );

		$checkout = JSFactory::getModel( 'checkoutOrder', 'jshop' );
		$checkout->checkStep( 6 );
		// if $checkout->getSendEndForm() == 1 order will be canceled when user reload page (even if order was paid)
		$checkout->setSendEndForm( 0 );
		if ( $order->order_status == $pmconfigs['transaction_end_status'] ) {
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

	private function getAmount( $order ) {
		$total = number_format( $order->order_total / $order->currency_exchange, 2, '.', '' );

		return $total;
	}

	private function log( $msg ) {
		saveToLog( "paymentdata.log", $msg );
	}

	/**
	 * @param $order jshopOrder
	 *
	 * @return float|int
	 */
	private function getRefundedAmount( $order ) {
		$transactions = $order->getListTransactions();
		if ( ! $transactions ) {
			return 0;
		}
		$refunded_amount = 0;
		foreach ( $transactions as $transaction ) {
			foreach ( $transaction->data as $data_obj ) {
				if ( $data_obj->key == 'refund_amount' ) {
					$refunded_amount += floatval( $data_obj->value );
				}

			}
		}

		return $refunded_amount;
	}

	function getUrlParams( $pmconfigs ) {
		$params                      = array();
		$params['order_id']          = $_POST['ACCOUNT'];
		$params['hash']              = "";
		$params['checkHash']         = 0;
		$params['checkReturnParams'] = 0;

		return $params;
	}

	function loadLangFile() {
		$lang = JFactory::getLanguage();
		if ( ! $lang_file = JPATH_SITE . '/components/com_jshopping/payments/pm_arsenalpay/lang/' . $lang->getTag() . '.pm_arsenalpay.php' ) {
			require_once JPATH_ROOT . '/components/com_jshopping/payments/arsenalpay/lang/' . 'en-GB.pm_arsenalpay.php';
		}
		else {
			require_once $lang_file;
		}
	}

}
