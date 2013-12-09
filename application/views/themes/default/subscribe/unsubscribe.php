<?load_theme_view('inc/tpl-cur-location'); ?>

<h2><?=$BC->_getPageTitle()?></h2>

<form id="unsubscribe_form" action="#" method="post">
	<div id="subscribe_results"></div>
	<div><input type="text" name="email" value="<?=language('email')?>" id="subscribe_email" /></div> 
	<div><input type="button" value="<?=language('unsubscribe')?>" id="unsubscribe" /></div>
</form>

<?=include_js($BC->_getFolder('js').'custom/subscribe/unsubscribe.js"')?>