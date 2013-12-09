<?=language('newsletters')?>
<form method="post" id="subscribe_form" action="#">
	<div id="subscribe_results"></div>
	<div><input type="text" name="email" value="E-Mail" id="subscribe_email" /></div> 
	<div><input type="button" value="<?=language('subscribe')?>" id="subscribe" /></div>
	<div><?=anchor_base('subscribe/unsubscribe',language('unsubscribe'))?></div>
</form>

<?=include_js($BC->_getFolder('js').'custom/subscribe/subscribe.js')?>