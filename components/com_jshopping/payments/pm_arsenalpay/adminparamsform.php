<?php
/**
 * @version     1.1.0 16.04.2018
 * @author      ArsenalPay Dev. Team
 * @package     Jshopping
 * @copyright   Copyright (C) 2014-2018 ArsenalPay. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die(); ?>
<div class="col100">
    <fieldset class="adminform">
        <table class="admintable" width="100%">
            <tr>
                <td style="width:275px;" class="key">
					<?php echo _JSHOP_ARS_CALLBACK_URL; ?>
                </td>
                <td>
                    <div><?php print JURI::root() . "index.php?option=com_jshopping&controller=checkout&task=step7&act=notify&js_paymentclass=pm_arsenalpay&no_lang=1"; ?></div>
                </td>
            </tr>
            <tr>
                <td style="width:275px;" class="key">
					<?php echo _JSHOP_ARS_WIDGET_ID; ?><span style="color:red"> *</span>
                </td>
                <td>
                    <input type="text" class="inputbox" name="pm_params[widget_id]" size="45"
                           value="<?php echo $params['widget_id'] ?>"/>
					<?php echo JHTML::tooltip(_JSHOP_ARS_WIDGET_ID_TIP); ?>
                </td>
            </tr>
            <tr>
                <td style="width:275px;" class="key">
					<?php echo _JSHOP_ARS_WIDGET_KEY; ?><span style="color:red"> *</span>
                </td>
                <td>
                    <input type="text" class="inputbox" name="pm_params[widget_key]" size="45"
                           value="<?php echo $params['widget_key'] ?>"/>
					<?php echo JHTML::tooltip(_JSHOP_ARS_WIDGET_KEY_TIP); ?>
                </td>
            </tr>
            <tr>
                <td style="width:275px;" class="key">
					<?php echo _JSHOP_ARS_CALLBACK_KEY; ?><span style="color:red"> *</span>
                </td>
                <td>
                    <input type="text" class="inputbox" name="pm_params[callback_key]" size="45"
                           value="<?php echo $params['callback_key'] ?>"/>
					<?php echo JHTML::tooltip(_JSHOP_ARS_CALLBACK_KEY_TIP); ?>
                </td>
            </tr>
            <tr>
                <td style="width:275px;" class="key">
					<?php echo _JSHOP_ARS_ALLOWED_IP; ?>
                </td>
                <td>
                    <input type="text" class="inputbox" name="pm_params[allowed_ip]" size="45"
                           value="<?php echo $params['allowed_ip'] ?>"/>
					<?php echo JHTML::tooltip(_JSHOP_ARS_ALLOWED_IP_TIP); ?>
                </td>
            </tr>
            <tr>
                <td class="key">
					<?php echo _JSHOP_ARS_PAYMENT_STATUS; ?><span style="color:red"> *</span>
                </td>
                <td>
					<?php
					echo JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_end_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_end_status']);
					?>
                </td>
            </tr>
            <tr>
                <td class="key">
					<?php echo _JSHOP_ARS_CHECK_STATUS; ?><span style="color:red"> *</span>
                </td>
                <td>
					<?php
					echo JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_pending_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_pending_status']);
					?>
                </td>
            </tr>
            <tr>
                <td class="key">
					<?php echo _JSHOP_ARS_CANCEL_STATUS; ?><span style="color:red"> *</span>
                </td>
                <td>
					<?php
					echo JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_cancel_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_cancel_status']);
					?>
                </td>
            </tr>
            <tr>
                <td class="key">
					<?php echo _JSHOP_ARS_HOLD_STATUS; ?><span style="color:red"> *</span>
                </td>
                <td>
					<?php
					echo JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_open_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_open_status']);
					?>
					<?php echo JHTML::tooltip(_JSHOP_ARS_HOLD_STATUS_TIP); ?>
                </td>
            </tr>
            <tr>
                <td class="key">
					<?php echo _JSHOP_ARS_REFUND_STATUS; ?><span style="color:red"> *</span>
                </td>
                <td>
					<?php
					echo JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_refunded_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_refunded_status']);
					?>
                </td>
            </tr>
            <tr>
                <td class="key">
					<?php echo _JSHOP_ARS_REVERSE_STATUS; ?><span style="color:red"> *</span>
                </td>
                <td>
					<?php
					echo JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_other_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_other_status']);
					?>
                </td>
            </tr>
            <tr><td></td><td></td></tr>
            <tr>
                <td colspan="2">
			        <?php echo _JSHOP_ARS_TAX_DESCR; ?>
                </td>
            </tr>
            <tr>
                <td class="key">
					<?php echo _JSHOP_ARS_PRODUCT_TAX; ?>
                </td>
                <td>
					<?php
					echo JHTML::_('select.genericlist', $taxes, 'pm_params[product_tax]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['product_tax']);
					?>
                </td>
            </tr>
            <tr>
                <td class="key">
					<?php echo _JSHOP_ARS_SHIPMENT_TAX; ?>
                </td>
                <td>
					<?php
					echo JHTML::_('select.genericlist', $taxes, 'pm_params[shipment_tax]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['shipment_tax']);
					?>
                </td>
            </tr>
            <tr><td></td><td></td></tr>
            <tr>
                <td style="width:275px;" class="key">
					<?php echo _JSHOP_ARS_RETURN_URL; ?>
                </td>
                <td>
                    <div>
						<?php print JURI::root() . "index.php?option=com_jshopping&controller=checkout&task=step7&act=return&js_paymentclass=pm_arsenalpay"; ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width:275px;" class="key">
					<?php echo _JSHOP_ARS_CANCEL_URL; ?>
                </td>
                <td>
                    <div>
						<?php print JURI::root() . "index.php?option=com_jshopping&controller=checkout&task=step7&act=cancel&js_paymentclass=pm_arsenalpay"; ?>
                    </div>
                </td>
            </tr>

        </table>
    </fieldset>
</div>
<br/>
<div style="padding-top:10px;">
    <div class="requiredtext" style="color:red">* <?php echo _JSHOP_ARS_REQUIRED_TEXT; ?></div>
    <div class="clr"></div>


