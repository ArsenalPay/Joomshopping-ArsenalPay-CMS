<?php
/**
 * @version     1.0.3 02.11.2017
 * @author      ArsenalPay Dev. Team
 * @package     Jshopping
 * @copyright   Copyright (C) 2014-2017 ArsenalPay. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
define( '_JSHOP_ARS_WIDGET_ID', 'widget' );
define( '_JSHOP_ARS_WIDGET_ID_TIP', 'Присваивается предприятию для доступа к платежному виджету.' );
define( '_JSHOP_ARS_WIDGET_KEY', 'widgetKey' );
define( '_JSHOP_ARS_WIDGET_KEY_TIP', 'Присваивается предприятию для доступа к платежному виджету.' );
define( '_JSHOP_ARS_CALLBACK_KEY', 'callbackKey' );
define( '_JSHOP_ARS_CALLBACK_KEY_TIP', 'Ключ для проверки подписи обратных запросов.' );
define( '_JSHOP_ARS_CALLBACK_URL', 'URL для обратного запроса' );
define('_JSHOP_ARS_ALLOWED_IP','Разрешенный IP-адрес');
define('_JSHOP_ARS_ALLOWED_IP_TIP','Только с которого будут разрешены обратные запросы о подтверждении платежей от ArsenalPay.');

define( '_JSHOP_ARS_RETURN_URL', 'URL возврата в случае успешной оплаты' );
define( '_JSHOP_ARS_CANCEL_URL', 'URL возврата в случае отмененной оплаты' );

define( '_JSHOP_ARS_PAYMENT_STATUS', 'Статус заказа после успешного подтверждения платежа' );
define( '_JSHOP_ARS_CHECK_STATUS', 'Статус заказа на время ожидания оплаты' );
define( '_JSHOP_ARS_HOLD_STATUS', 'Статус заказа при резервировании платежа' );
define( '_JSHOP_ARS_HOLD_STATUS_TIP', 'Средства на карте были зарезервированы, но еще не списаны' );
define( '_JSHOP_ARS_CANCEL_STATUS', 'Статус заказа после отмененного платежа' );
define( '_JSHOP_ARS_REFUND_STATUS', 'Статус заказа после частичного возврата платежа' );
define( '_JSHOP_ARS_REVERSE_STATUS', 'Статус заказа после полного возврата платежа' );

define( '_JSHOP_ARS_REQUIRED_TEXT', 'Обязательные поля' );

?>