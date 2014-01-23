<style>
    .fb-output-screen { width:370px; }
</style>

<?=load_inline_js('inc/js-jquery-ui'); ?>

<?=include_css($BC->_getFolder('js').'fullcalendar/fullcalendar.css')?>
<?=include_css($BC->_getFolder('js').'fullcalendar/fullcalendar.print.css','print')?>
<?=include_js($BC->_getFolder('js').'fullcalendar/fullcalendar.min.js')?>

<?=load_inline_js('inc/js-facebox'); ?>

<?=load_inline_js('inc/js-agenda'); ?>

<div id="agenda"></div>