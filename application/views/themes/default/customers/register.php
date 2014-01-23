<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<?load_theme_view('inc/form-customer-info')?>

<p><?=form_checkbox("subscribe",1,true)?> <?=language('subscribe')?></p>

<p><?=$cap_img?></p>
<p>
	<?=$BC->_getFieldTitle('captcha');?>: <br />
	<input type="text" name="captcha" value="" />
</p>

<p><?=form_submit("submit",language('register1'))?></p>

</form>

<?=load_inline_js('inc/js-register')?>