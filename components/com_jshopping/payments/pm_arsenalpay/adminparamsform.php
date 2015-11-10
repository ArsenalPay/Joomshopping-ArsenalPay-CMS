<?php
/**
 * @version     1.0.0 11.11.2014
 * @author      ArsenalPay Dev. Team
 * @package     Jshopping
 * @copyright   Copyright (C) 2014-2015 ArsenalPay. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL 
 */
defined('_JEXEC') or die(); ?>
<div class="col100">
<fieldset class="adminform">
<table class="admintable" width = "100%" >
 <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_UNIQUE_ID;?><span style="color:red"> *</span>
   </td>
   <td>
	   <input type = "text" class = "inputbox" name = "pm_params[unique_id]" size="45" value = "<?php echo $params['unique_id']?>" />
	   <?php echo JHTML::tooltip(_JSHOP_ARS_UNIQUE_ID_TIP);?>
   </td>
 </tr>
 <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_FRAME_URL;?><span style="color:red"> *</span>
   </td>
   <td>
	<?php 
		$params['frame_url'] = "https://arsenalpay.ru/payframe/pay.php" ?>
	   <input type = "text" class = "inputbox" name = "pm_params[frame_url]" size="45"  value = "<?php echo $params['frame_url']?>" />
	    <?php echo JHTML::tooltip(_JSHOP_ARS_FRAME_URL_TIP);?>
   </td>
 </tr>
 <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_PAYMENT_SRC;?><span style="color:red"> *</span>
   </td>
   <td> 
   <?php
   $options = array(
	 JHTML::_('select.option', 'card', JText::_('card') ),
	 JHTML::_('select.option', 'mk', JText::_('mk') ),  
	);
    print JHTML::_('select.genericlist', $options, "pm_params[payment_src]" , 'class = "inputbox" size = "1"', 'value', 'text', $params['payment_src']);
	echo JHTML::tooltip(_JSHOP_ARS_PAYMENT_SRC_TIP);?>
   </td>
 </tr>
  <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_CSS_URL;?>
   </td>
   <td>
	   <input type = "text" class = "inputbox" name = "pm_params[css_url]" size="45" value = "<?php echo $params['css_url']?>" />
           <?php echo JHTML::tooltip(_JSHOP_ARS_CSS_URL_TIP);?>
   </td>
 </tr>
  <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_SIGN_KEY;?><span style="color:red"> *</span>
   </td>
   <td>
	   <input type = "text" class = "inputbox" name = "pm_params[sign_key]" size="45" value = "<?php echo $params['sign_key']?>" />
	   <?php echo JHTML::tooltip(_JSHOP_ARS_SIGN_KEY_TIP);?>
   </td>
 </tr>
  <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_ALLOWED_IP;?>
   </td>
   <td>
	   <input type = "text" class = "inputbox" name = "pm_params[allowed_ip]" size="45" value = "<?php echo $params['allowed_ip']?>" />
	   <?php echo JHTML::tooltip(_JSHOP_ARS_ALLOWED_IP_TIP);?>
   </td>
 </tr>
  <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_CALLBACK_URL;?><span style="color:red"> *</span>
   </td>
   <td>
	 <input type = "text" class = "inputbox" name = "pm_params[callback_url]" size="45"  value = "<?php print JURI::root(). "index.php?option=com_jshopping&controller=checkout&task=step7&act=notify&js_paymentclass=pm_arsenalpay&no_lang=1";?>" />
   </td>
 </tr>
  <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_CHECK_URL;?>
   </td>
   <td>
	   <input type = "text" class = "inputbox" name = "pm_params[check_url]" size="45" value = "<?php echo $params['check_url']?>" />
	   <?php echo JHTML::tooltip(_JSHOP_ARS_CHECK_URL_TIP);?>
   </td>
 </tr>
  <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_RETURN_URL;?>
   </td>
   <td>
	 <input type = "text" class = "inputbox" name = "pm_params[return_url]" size="45"  value = "<?php print JURI::root(). "index.php?option=com_jshopping&controller=checkout&task=step7&act=return&js_paymentclass=pm_arsenalpay";?>" />
   </td>
 </tr>
 <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_CANCEL_URL;?>
   </td>
   <td>
	 <input type = "text" class = "inputbox" name = "pm_params[cancel_url]" size="45"  value = "<?php print JURI::root(). "index.php?option=com_jshopping&controller=checkout&task=step7&act=cancel&js_paymentclass=pm_arsenalpay";?>" />
   </td>
 </tr>
  <tr>
   <td class="key">
     <?php echo _JSHOP_ARS_STATUS_END;?><span style="color:red"> *</span>
   </td>
   <td>
     <?php              
     print JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_end_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_end_status'] );
     ?>
   </td>
 </tr>
  <tr>
   <td class="key">
     <?php echo _JSHOP_ARS_STATUS_PENDING;?><span style="color:red"> *</span>
   </td>
   <td>
	 <?php 
     echo JHTML::_('select.genericlist',$orders->getAllOrderStatus(), 'pm_params[transaction_pending_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_pending_status']);
     ?>
   </td>
 </tr>
  <tr>
   <td class="key">
     <?php echo _JSHOP_ARS_STATUS_FAILED;?><span style="color:red"> *</span>
   </td>
   <td>
     <?php 
     echo JHTML::_('select.genericlist',$orders->getAllOrderStatus(), 'pm_params[transaction_failed_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_failed_status']);
     ?>
   </td>
 </tr>
  <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_FRAME_MODE;?>
   </td>
   <td>
   <?php
		$options = array(
		JHTML::_('select.option', '1', JText::_('1') ),
		JHTML::_('select.option', '0', JText::_('0') ),  
		);
		print JHTML::_('select.genericlist', $options, "pm_params[frame_mode]" , 'class = "inputbox" size = "1"', 'value', 'text', $params['frame_mode']);
		echo JHTML::tooltip(_JSHOP_ARS_FRAME_MODE_TIP);?>
   </td>
 </tr>
 <th colspan=2><?php echo _JSHOP_ARS_FRAME_PARAMS_SECTION;?></th>
 <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_FRAME_WIDTH;?>
   </td>
   <td>
	   <input type = "text" class = "inputbox" name = "pm_params[frame_width]" size="45" value = "<?php echo $params['frame_width']?>" />
   </td>
 </tr>
  <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_FRAME_HEIGHT;?>
   </td>
   <td>
	   <input type = "text" class = "inputbox" name = "pm_params[frame_height]" size="45" value = "<?php echo $params['frame_height']?>" />
   </td>
 </tr>
  <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_FRAME_BORDER;?>
   </td>
   <td>
	   <input type = "text" class = "inputbox" name = "pm_params[frame_border]" size="45" value = "<?php echo $params['frame_border']?>" />
   </td>
 </tr>
  <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_FRAME_SCROLLING;?>
   </td>
   <td>
	   <input type = "text" class = "inputbox" name = "pm_params[frame_scrolling]" size="45" value = "<?php echo $params['frame_scrolling']?>" />
   </td>
 </tr>
 </table>
</fieldset>
</div>
<div style="padding-top:10px;">
     <div class="requiredtext" style="color:red">* <?php echo _JSHOP_ARS_REQUIRED_TEXT;?></div>
<div class="clr"></div>


