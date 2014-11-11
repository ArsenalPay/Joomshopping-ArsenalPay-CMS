<?php defined('_JEXEC') or die(); ?>
<div class="col100">
<fieldset class="adminform">
<table class="admintable" width = "100%" >
 <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_UNIQUE_ID;?>
   </td>
   <td>
	   <input type = "text" class = "inputbox" name = "pm_params[unique_id]" size="45" value = "<?php echo $params['unique_id']?>" />
   </td>
 </tr>
 <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_FRAME_URL;?>
   </td>
   <td>
	   <input type = "text" class = "inputbox" name = "pm_params[frame_url]" size="45" value = "<?php echo $params['frame_url']?>" />
   </td>
 </tr>
 <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_PAYMENT_SRC;?>
   </td>
   <td>
	   <input type = "text" class = "inputbox" name = "pm_params[payment_src]" size="45" value = "<?php echo $params['payment_src']?>" />
	   <?php echo JHTML::tooltip(_JSHOP_ARS_PAYMENT_SRC_TIP);?>
   </td>
 </tr>
  <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_ALLOWED_IP;?>
   </td>
   <td>
	   <input type = "text" class = "inputbox" name = "pm_params[allowed_ip]" size="45" value = "<?php echo $params['allowed_ip']?>" />
   </td>
 </tr>
  <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_SIGN_KEY;?>
   </td>
   <td>
	   <input type = "text" class = "inputbox" name = "pm_params[sign_key]" size="45" value = "<?php echo $params['sign_key']?>" />
	   <?php echo JHTML::tooltip(_JSHOP_ARS_SIGN_KEY_TIP);?>
   </td>
 </tr>
  <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_CSS_URL;?>
   </td>
   <td>
	   <input type = "text" class = "inputbox" name = "pm_params[css_url]" size="45" value = "<?php echo $params['css_url']?>" />
   </td>
 </tr>
  <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_FRAME_MODE;?>
   </td>
   <td>
	   <input type = "text" class = "inputbox" name = "pm_params[frame_mode]" size="45" value = "<?php echo $params['frame_mode']?>" />
	   <?php echo JHTML::tooltip(_JSHOP_ARS_FRAME_MODE_TIP);?>
   </td>
 </tr>
  <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_CHECK_URL;?>
   </td>
   <td>
	   <input type = "text" class = "inputbox" name = "pm_params[payer_callback_url]" size="45" value = "<?php echo $params['check_url']?>" />
   </td>
 </tr>
  <tr>
   <td style="width:250px;" class="key">
     <?php echo _JSHOP_ARS_CALLBACK_URL;?>
   </td>
   <td>
	 <?php 
     print JURI::root(). "index.php?option=com_jshopping&controller=checkout&task=step7&act=notify&js_paymentclass=pm_arsenalpay&no_lang=1";
     ?>
   </td>
 </tr>
 <tr>
   <td class="key">
     <?php echo _JSHOP_ARS_RETURN_URL;?>
   </td>
   <td>
     <?php 
     print JURI::root(). "index.php?option=com_jshopping&controller=checkout&task=step7&act=return&js_paymentclass=pm_arsenalpay&no_lang=1";
     ?>
   </td>
 </tr>
 <tr>
   <td class="key">
     <?php echo _JSHOP_ARS_CANCEL_URL;?>
   </td>
   <td>
     <?php 
     print JURI::root(). "index.php?option=com_jshopping&controller=checkout&task=step7&act=cancel&js_paymentclass=pm_arsenalpay&no_lang=1";
     ?>
   </td>
 </tr>
  <tr>
   <td class="key">
     <?php echo _JSHOP_ARS_STATUS_END;?>
   </td>
   <td>
     <?php              
     print JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_end_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_end_status'] );
     ?>
   </td>
 </tr>
  <tr>
   <td class="key">
     <?php echo _JSHOP_ARS_STATUS_PENDING;?>
   </td>
   <td>
	 <?php 
     echo JHTML::_('select.genericlist',$orders->getAllOrderStatus(), 'pm_params[transaction_pending_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_pending_status']);
     ?>
   </td>
 </tr>
  <tr>
   <td class="key">
     <?php echo _JSHOP_ARS_STATUS_FAILED;?>
   </td>
   <td>
     <?php 
     echo JHTML::_('select.genericlist',$orders->getAllOrderStatus(), 'pm_params[transaction_failed_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_failed_status']);
     ?>
   </td>
 </tr>
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


