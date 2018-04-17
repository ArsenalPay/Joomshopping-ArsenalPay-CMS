<?php
/**
 * @version     1.1.0 16.04.2018
 * @author      ArsenalPay Dev. Team
 * @package     Jshopping
 * @copyright   Copyright (C) 2014-2018 ArsenalPay. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<script type="text/javascript">
    function check_ <?php print $paymentPluginClass; ?>() {
        jQuery('#payment_form').submit();
    }
</script>
