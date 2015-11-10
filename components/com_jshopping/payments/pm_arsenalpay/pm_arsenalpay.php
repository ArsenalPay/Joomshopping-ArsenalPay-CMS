<?php
/**
 * @version     1.0.0 11.11.2014
 * @author      ArsenalPay Dev. Team
 * @package     Jshopping
 * @copyright   Copyright (C) 2014-2015 ArsenalPay. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL 
 */
defined('_JEXEC') or die('Restricted access');

class pm_arsenalpay extends PaymentRoot 
{
	/**
    * static
    * Checkout Step3
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
        include(dirname(__FILE__)."/adminparamsform.php");	
    }
	
	
	/**
    * Check Transaction - here is the handling of callback requests about payments
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
			'ID',           /* Merchant identifier */
			'FUNCTION',     /* Type of request to which the response is received*/
			'RRN',          /* Transaction identifier */
			'PAYER',        /* Payer(customer) identifier */
			'AMOUNT',       /* Payment amount */
			'ACCOUNT',      /* Order number */
			'STATUS',       /* Payment status. When 'check' - response for the order number checking, when 'payment' - response for status change.*/
			'DATETIME',     /* Date and time in ISO-8601 format, urlencoded.*/
			'SIGN',         /* Callback request sign. = md5(md5(ID).md(FUNCTION).md5(RRN).md5(PAYER).md5(AMOUNT).md5(ACCOUNT).md(STATUS).md5(PASSWORD)) */       
			); 
		/**
        * Checking the presence of each parameter in the post response.
        */
		foreach( $keyArray as $key ) {
			if( empty( $ars_callback[$key] )||!array_key_exists( $key,$ars_callback) ){
				echo 'ERR_'.$key;
				return array(0, 'ERR_'.$key.'. Order ID '.$order->order_id);
			}
		} 
		/*If it is needed to check the account existense before payment confirmation*/
		if ($ars_callback['FUNCTION'] == 'check' && $ars_callback['STATUS'] == 'check'){
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
         * Checking validness of the request sign.
         */
		if( !( $this->_checkSign( $ars_callback, $pmconfigs['sign_key'] ) ) ) {
			echo 'ERR_INVALID_SIGN';
			return array(0,'ERR_INVALID_SIGN'.$order->order_id);
		}
				
		if (($ars_callback['FUNCTION']=="payment") && ($ars_callback['STATUS']=="payment") ) {
			$cart = JSFactory::getModel('cart', 'jshop');
			$cart->load();
			$cart->getSum();
			$cart->clear();
			echo 'OK';
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
		
	/*Checkout Step6 - show ArsenalPay payment frame*/
	function showEndForm($pmconfigs, $order)
	{   
		$f_url = $pmconfigs['frame_url'];
		$f_width = !empty( $pmconfigs['frame_width'] ) ? $pmconfigs['frame_width'] : '100%';
		$f_height = !empty( $pmconfigs['frame_height'] ) ? $pmconfigs['frame_height'] : '500' ;
		$f_border = !empty( $pmconfigs['frame_border'] ) ? $pmconfigs['frame_border'] : '0';
		$f_scrolling = !empty( $pmconfigs['frame_scrolling'] ) ? $pmconfigs['frame_border'] : 'no';
		
        // sum of order
        $out_summ = number_format( $order->order_total / $order->currency_exchange, 2, '.','' );
		$url_params = array(
				'src' => $pmconfigs['payment_src'],
				't' => $pmconfigs['unique_id'],
				'n' => $order->order_id,
				'a' => $out_summ,
				'msisdn'=> '',
				'css' => $pmconfigs['css_url'],
				'frame' => $pmconfigs['frame_mode'],
            );
		$ap_frame_src = $f_url.'?'.http_build_query($url_params, '', '&');
		?>
		<iframe id='arspay' src="<?=$ap_frame_src?>" seamless="seamless" width=<?=$f_width?> height=<?=$f_height?> frameborder=<?=$f_border?> scrolling=<?=$f_scrolling?>></iframe>
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
		if (!$lang_file = JPATH_SITE.'/components/com_jshopping/payments/pm_arsenalpay/lang/' . $lang->getTag() . '.pm_arsenalpay.php') {
			require_once JPATH_ROOT . '/components/com_jshopping/payments/arsenalpay/lang/' . 'en-GB.pm_arsenalpay.php';
			}
		else {
			require_once $lang_file;
			}
	}
    
}
