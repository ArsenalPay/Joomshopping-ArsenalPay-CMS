<?php
defined('_JEXEC') or die('Restricted access');

class pm_arsenalpay extends PaymentRoot 
{
	var $_errormessage = "";
	
	/**
    * static
    * show form payment. Checkout Step3
    * @param array $params - entered params
    * @param array $pmconfigs - configs
    */    
	function showPaymentForm($params, $pmconfigs){
        include(dirname(__FILE__)."/paymentform.php");
    }
/////////////////////////////////////////////////////////////
	/**
    * Form parameters. Edit params payment in administrator.
    * static
    */
    function showAdminFormParams($params) 
	{
		$this->loadLangFile();
        $array_params = array('unique_id', 'frame_url', 'payment_src', 'allowed_ip', 'sign_key', 'css_url', 'frame_mode', 
								'transaction_end_status','transaction_pending_status', 'transaction_failed_status', 'frame_width', 'frame_height', 'frame_border', 'frame_scrolling');
		foreach ($array_params as $key) {
            if (!isset($params[$key])) 
                $params[$key] = '';
		}
		$orders = JSFactory::getModel('orders', 'JshoppingModel'); //admin model
		//@$orders = &JModel::getInstance('orders', 'JshoppingModel');
		//@$currency = &JModel::getInstance('currencies', 'JshoppingModel'); 
        include(dirname(__FILE__)."/adminparamsform.php");	
        
      // jimport('joomla.html.pane');
       // @$pane =& JPane::getInstance('Tabs');
       // echo $pane->endPanel();
    }
	
	
	/**
    * Check Transaction
    * @param array $pmconfigs parameters
    * @param object $order order
    * @param string $act action
    * @return array($rescode, $restext, $transaction, $transactiondata)
    */
    function checkTransaction($pmconfigs, $order, $act)
    {
		$ars_callback = JRequest::get('post');
		$REMOTE_ADDR = $_SERVER["REMOTE_ADDR"];
		$IP_ALLOW = $pmconfigs['allowed_ip']; 
		if(strlen($IP_ALLOW)>0 && $IP_ALLOW!=$REMOTE_ADDR) {
			echo 'ERR_IP';
			return array(0, 'ERR_IP Order ID '.$order->order_id);
		}
		if (number_format($order->order_total / $order->currency_exchange, 2, '.','' ) != $ars_callback['AMOUNT']){
			echo 'ERR_AMOUNT';
            return array(0, 'ERR_AMOUNT. Order ID '.$order->order_id);
        }
		$keyArray = array(
			'ID',           /* Идентификатор ТСП/ merchant identifier */
			'FUNCTION',     /* Тип запроса/ type of request to which the response is received*/
			'RRN',          /* Идентификатор транзакции/ transaction identifier */
			'PAYER',        /* Идентификатор плательщика/ payer(customer) identifier */
			'AMOUNT',       /* Сумма платежа/ payment amount */
			'ACCOUNT',      /* Номер получателя платежа (номер заказа, номер ЛС) на стороне ТСП/ order number */
			'STATUS',       /* Статус платежа - check - запрос на проверку номера получателя : payment - запрос на передачу статуса платежа
                        /* Payment status. When 'check' - response for the order number checking, when 'payment' - response for status change.*/
			'DATETIME',     /* Дата и время в формате ISO-8601 (YYYY-MM-DDThh:mm:ss±hh:mm), УРЛ-кодированное */
                        /* Date and time in ISO-8601 format, urlencoded.*/
			'SIGN',         /* Подпись запроса/ response sign.
                    //    * = md5(md5(ID).md(FUNCTION).md5(RRN).md5(PAYER).md5(AMOUNT).md5(ACCOUNT).md(STATUS).md5(PASSWORD)) */       
			); 
		/**
        * Checking the absence of each parameter in the post response.
        * Проверка на присутствие каждого из параметров и их значений в передаваемом запросе. 
        */
		foreach( $keyArray as $key ) {
			if( empty( $ars_callback[$key] )||!array_key_exists( $key,$ars_callback) ){
				echo 'ERR_'.$key;
				return array(0, 'ERR_'.$key.'. Order ID '.$order->order_id);
			}
		} 
		/*If it is needed to precheck of account existense*/
		if ($ars_callback['FUNCTION'] == 'check'){
			if ($order->order_id === $ars_callback['ACCOUNT']){
				echo 'YES';
				return array(2, 'YES. Order ID '.$order->order_id);
				}
			else{
				echo 'NO';
				return array(0, 'ERR_CHECK. Order ID is not as'.$ars_callback['ACCOUNT']);
				}
		}
	
        /**
         * Checking validness of the response sign.
         */
		if( !( $this->_checkSign( $ars_callback, $pmconfigs['sign_key'] ) ) ) {
			//============== For testing, delete after testing =============================
			$S=md5(md5($ars_callback['ID']).
                md5($ars_callback['FUNCTION']).md5($ars_callback['RRN']).
                md5($ars_callback['PAYER']).md5($ars_callback['AMOUNT']).md5($ars_callback['ACCOUNT']).
                md5($ars_callback['STATUS']).md5($pmconfigs['sign_key']) );
			echo $S.'</br>';
        //======================================
			echo 'ERR_INVALID_SIGN';
			return array(0,'ERR_INVALID_SIGN'.$order->order_id);
		}
		
		
		if (($ars_callback['FUNCTION']=="payment")) {
			echo 'OK';
			$cart = JModel::getInstance('cart', 'jshop');
			$cart->load();
			$cart->clear();	
			return array(1, 'OK. Order ID '.$order->order_id);
		}
		else {
			echo 'ERR_FUNCTION';
			return array(0, 'ERR_FUNCTION. Order ID '.$order->order_id);
		}
	}
	private function _checkSign( $callback, $pass){
        
        $validSign = ( $callback['SIGN'] === md5(md5($callback['ID']).
                md5($callback['FUNCTION']).md5($callback['RRN']).
                md5($callback['PAYER']).md5($callback['AMOUNT']).md5($callback['ACCOUNT']).
                md5($callback['STATUS']).md5($pass) ) )? true : false;
        return $validSign; 
		}
	
	function showEndForm($pmconfigs, $order)
	{       
		$token = $pmconfigs['unique_id'];
		$src = $pmconfigs['payment_src'];
		$f_url = $pmconfigs['frame_url'];
		$f_mode = $pmconfigs['frame_mode'];
		$css_file = $pmconfigs['css_url'];
		$f_width = $pmconfigs['frame_width'];
		$f_height = $pmconfigs['frame_height'];
		$f_border = $pmconfigs['frame_border'];
		$f_scrolling = $pmconfigs['frame_scrolling'];
		
        // sum of order
        $out_summ = number_format( $order->order_total / $order->currency_exchange, 2, '.','' );
		?>
		<iframe id='arspay' src="<?=$f_url?>?src=<?=$src?>&t=<?=$token?>&n=<?=$order->order_id?>&a=<?=$out_summ?>&css=<?=$css_file?>&frame=<?=$f_mode?>" seamless="seamless" width=<?=$f_width?> height=<?=$f_height?> frameborder=<?=$f_border?> scrolling=<?=$f_scrolling?>></iframe>>
		<?php 		
      }
	
    function getUrlParams($pmconfigs)
    {                        
        $params = array(); 
        $params['order_id'] = JRequest::getInt("ACCOUNT");
        $params['hash'] = "";
        $params['checkHash'] = 0;
        $params['checkReturnParams'] = 0;
        return $params;
    }
	
	function loadLangFile() {
		$lang = JFactory::getLanguage();
		if (!$lang_file = JPATH_SITE.'/components/com_jshopping/lang/' . $lang->getTag() . '.pm_arsenalpay.php') {
			require_once JPATH_ROOT . '/components/com_jshopping/lang/' . 'en-GB.pm_arsenalpay.php';
			}
		else {
			require_once $lang_file;
			}
	}
    
}
