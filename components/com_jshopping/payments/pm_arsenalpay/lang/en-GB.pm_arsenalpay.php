<?php
/**
 * @version     1.0.3 22.11.2017
 * @author      ArsenalPay Dev. Team
 * @package     Jshopping
 * @copyright   Copyright (C) 2014-2017 ArsenalPay. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
define( '_JSHOP_ARS_WIDGET_ID', 'widget' );
define( '_JSHOP_ARS_WIDGET_ID_TIP', 'Assigned to merchant for access to ArsenalPay payment widget.' );
define( '_JSHOP_ARS_WIDGET_KEY', 'widgetKey' );
define( '_JSHOP_ARS_WIDGET_KEY_TIP', 'Assigned to merchant for access to ArsenalPay payment widget.' );
define( '_JSHOP_ARS_CALLBACK_KEY', 'callbackKey' );
define( '_JSHOP_ARS_CALLBACK_KEY_TIP', 'With this key you check a validity of sign that comes with callback payment data.' );
define( '_JSHOP_ARS_CALLBACK_URL', 'Callback URL' );
define('_JSHOP_ARS_ALLOWED_IP','Allowed IP address');
define('_JSHOP_ARS_ALLOWED_IP_TIP','It can be allowed to receive ArsenalPay payment confirmation callback requests only from the ip address pointed out here.');

define( '_JSHOP_ARS_RETURN_URL', 'Return URL' );
define( '_JSHOP_ARS_CANCEL_URL', 'Cancel URL' );

define( '_JSHOP_ARS_PAYMENT_STATUS', 'Order Status for Successful transactions.' );
define( '_JSHOP_ARS_CHECK_STATUS', 'Order Status for Pending transactions.' );
define( '_JSHOP_ARS_HOLD_STATUS', 'Order Status for Hold transactions.' );
define( '_JSHOP_ARS_HOLD_STATUS_TIP', 'Funds were reserved on the card but not yet written off' );
define( '_JSHOP_ARS_CANCEL_STATUS', 'Order Status for Cancel transactions.' );
define( '_JSHOP_ARS_REFUND_STATUS', 'Order Status for Refund transactions.' );
define( '_JSHOP_ARS_REVERSE_STATUS', 'Order Status for Reverse transactions.' );

define( '_JSHOP_ARS_REQUIRED_TEXT', 'Required fields' );

?>