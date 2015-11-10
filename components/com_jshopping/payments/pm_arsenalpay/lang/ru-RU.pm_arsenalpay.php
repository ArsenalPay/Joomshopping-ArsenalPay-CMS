<?php
/**
 * @version     1.0.0 11.11.2014
 * @author      ArsenalPay Dev. Team
 * @package     Jshopping
 * @copyright   Copyright (C) 2014-2015 ArsenalPay. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL 
 */
defined('_JEXEC') or die('Restricted access');
define('_JSHOP_ARS_UNIQUE_ID','Уникальный токен');
define('_JSHOP_ARS_UNIQUE_ID_TIP','Присваивается предприятию для доступа к платежному фрейму.');
define('_JSHOP_ARS_FRAME_URL','URL-адрес фрейма');
define('_JSHOP_ARS_FRAME_URL_TIP','URL-адрес платежного фрейма ArsenalPay.');
define('_JSHOP_ARS_PAYMENT_SRC','Тип оплаты');
define('_JSHOP_ARS_PAYMENT_SRC_TIP','mk - оплата с мобильного телефона (мобильная коммерция). card - оплата с пластиковой карты (интернет эквайринг).');
define('_JSHOP_ARS_CSS_URL','Параметр css');
define('_JSHOP_ARS_CSS_URL_TIP','Aдрес (URL) CSS файла.');
define('_JSHOP_ARS_SIGN_KEY','Ключ (key)');
define('_JSHOP_ARS_SIGN_KEY_TIP','Для проверки подписи обратных запросов.');
define('_JSHOP_ARS_ALLOWED_IP','Разрешенный IP-адрес');
define('_JSHOP_ARS_ALLOWED_IP_TIP','Только с которого будут разрешены обратные запросы о подтверждении платежей от ArsenalPay.');
define('_JSHOP_ARS_CHECK_URL','URL для проверки');
define('_JSHOP_ARS_CHECK_URL_TIP','На проверку номера заказа.');
define('_JSHOP_ARS_CALLBACK_URL','URL для обратного запроса');
define('_JSHOP_ARS_RETURN_URL','URL возврата в случае успешной оплаты');
define('_JSHOP_ARS_CANCEL_URL','URL возврата в случае отмененной оплаты');
define('_JSHOP_ARS_STATUS_END','Статус заказа после подтверждения платежа');
define('_JSHOP_ARS_STATUS_PENDING','Статус заказа на время ожидания оплаты');
define('_JSHOP_ARS_STATUS_FAILED','Статус заказа после неудавшегося платежа');
define('_JSHOP_ARS_FRAME_MODE','Режим отображения фрейма');
define('_JSHOP_ARS_FRAME_MODE_TIP','1 - отображать фрейм внутри страницы сайта, 0 - на странице фрейма.');

define('_JSHOP_ARS_FRAME_PARAMS_SECTION', 'Параметры отображения iframe');
define('_JSHOP_ARS_FRAME_WIDTH','width');
define('_JSHOP_ARS_FRAME_HEIGHT','height');
define('_JSHOP_ARS_FRAME_BORDER','frameborder');
define('_JSHOP_ARS_FRAME_SCROLLING','scrolling');
define('_JSHOP_ARS_REQUIRED_TEXT','Обязательные поля');
?>