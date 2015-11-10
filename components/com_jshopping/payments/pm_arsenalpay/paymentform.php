<?php
/**
 * @version     1.0.0 11.11.2014
 * @author      ArsenalPay Dev. Team
 * @package     Jshopping
 * @copyright   Copyright (C) 2014-2015 ArsenalPay. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL 
 */
defined ('_JEXEC') or die('Restricted access'); 
?>
<script type="text/javascript">
function check_<?php print $paymentPluginClass; ?>(){
    jQuery('#payment_form').submit();
}
</script>
