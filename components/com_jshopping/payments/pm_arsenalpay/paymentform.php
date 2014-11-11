<?php defined('_JEXEC') or die('Restricted access'); ?>

<script type="text/javascript">
    function check_<?php print $paymentPluginClass; ?>(){
        jQuery('#payment_form').submit();
    }
</script>