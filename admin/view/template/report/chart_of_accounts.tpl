<?php echo $header; ?>
<p><a href="../../reports" target="_blank">Start here</p>
<?php if ($print_version) { ?>
<script type="text/javascript"><!--
$('#column-left').hide();
$('header').hide();
$('.breadcrumb').hide();
$('.panel-heading .pull-right').hide();
window.print();
//--></script>
<?php } ?>
<?php echo $footer; ?>