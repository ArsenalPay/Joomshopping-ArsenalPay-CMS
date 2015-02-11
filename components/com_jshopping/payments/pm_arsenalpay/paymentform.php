<?php
/**
* @version      1.0.0
* @author       ArsenalPay
* @package      Jshopping
* @copyright    Copyright (C) 2014 arsenalpay.ru. All rights reserved.
* @license      GNU/GPL
*/
defined ('_JEXEC') or die('Restricted access'); 
?>
<script type="text/javascript">
function check_<?php print $paymentPluginClass; ?>(){
    jQuery('#payment_form').submit();
}
</script>
