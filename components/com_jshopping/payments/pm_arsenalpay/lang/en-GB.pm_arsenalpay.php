<?php
/**
 * @version     1.0.0 11.11.2014
 * @author      ArsenalPay Dev. Team
 * @package     Jshopping
 * @copyright   Copyright (C) 2014-2015 ArsenalPay. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL 
 */
defined('_JEXEC') or die('Restricted access');
define('_JSHOP_ARS_UNIQUE_ID','Unique token');
define('_JSHOP_ARS_UNIQUE_ID_TIP','Assigned to merchant for access to ArsenalPay payment frame.');
define('_JSHOP_ARS_FRAME_URL','Frame URL');
define('_JSHOP_ARS_FRAME_URL_TIP','URL-address of ArsenalPay payment frame.');
define('_JSHOP_ARS_PAYMENT_SRC','Payment type');
define('_JSHOP_ARS_PAYMENT_SRC_TIP','mk - payment from mobile phone account (mobile-commerce). card - payment from plastic card (internet acquiring).');
define('_JSHOP_ARS_CSS_URL','css parameter');
define('_JSHOP_ARS_CSS_URL_TIP','URL of CSS file if exists.');
define('_JSHOP_ARS_SIGN_KEY','Sign key');
define('_JSHOP_ARS_SIGN_KEY_TIP','With this key you check a validity of sign coming with callback payment data.');
define('_JSHOP_ARS_ALLOWED_IP','Allowed IP address');
define('_JSHOP_ARS_ALLOWED_IP_TIP','It can be allowed to receive ArsenalPay payment confirmation callback requests only from the ip address pointed out here.');
define('_JSHOP_ARS_CHECK_URL','Check URL');
define('_JSHOP_ARS_CHECK_URL_TIP','To check an order number before payment processing.');
define('_JSHOP_ARS_CALLBACK_URL','Callback URL');
define('_JSHOP_ARS_FRAME_MODE','Frame mode');
define('_JSHOP_ARS_FRAME_MODE_TIP','1 will mean that frame will be displayed inside your site, 0 will mean to display in a frame page.');

define('_JSHOP_ARS_RETURN_URL','Return URL');
define('_JSHOP_ARS_CANCEL_URL','Cancel URL');
define('_JSHOP_ARS_STATUS_END','Order Status for Successful transactions.');
define('_JSHOP_ARS_STATUS_PENDING','Order Status for Pending transactions.');
define('_JSHOP_ARS_STATUS_FAILED','Order Status for Failed transactions.');

define('_JSHOP_ARS_FRAME_PARAMS_SECTION', 'ArsenalPay payment frame parameters');
define('_JSHOP_ARS_FRAME_WIDTH','width');
define('_JSHOP_ARS_FRAME_HEIGHT','height');
define('_JSHOP_ARS_FRAME_BORDER','frameborder');
define('_JSHOP_ARS_FRAME_SCROLLING','scrolling');
define('_JSHOP_ARS_REQUIRED_TEXT','Required fields');
?>