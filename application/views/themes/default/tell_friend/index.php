<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<p class="green" id="success"></p>
<p class="red" id="errors"></p>

<form id="tell_friend_form" action="#" method="post">
	
<p>
	<?=$BC->_getFieldTitle("name")?> <br />
	<input type="text" name="name" value="" />
</p>
<p>
	<?=$BC->_getFieldTitle("email")?> <br />
	<input type="text" name="email" value="" />
</p>
<p>
	<?=$BC->_getFieldTitle("friend_email")?> <br />
	<input type="text" name="friend_email" value="" />
</p>
<p>
	<?=$BC->_getFieldTitle("message")?> <br />
	<textarea name="message" class="textarea" rows="5" cols="53"></textarea>
</p>

<p><?=$cap_img?></p>
<p>
	<?=$BC->_getFieldTitle("captcha")?>: <br />
	<input type="text" name="captcha" value="" />
</p>

<p><?=form_submit("submit",language('submit'));?></p>

</form>
	
<?=include_js($BC->_getFolder('js').'custom/tell_friend/send_form.js')?>