<h1><?=$BC->_getPageTitle()?></h1>

<?
$contact_page = $BC->pages_model->getByLink('contact_us');
echo $contact_page['body'];
?>

<p class="green" id="success"></p>
<p class="red" id="errors"></p>

<form id="contact_form" action="#" method="post">

<p>
	<?=$BC->_getFieldTitle("name")?> <br />
	<input type="text" name="name" value="" />
</p>
<p>
	<?=$BC->_getFieldTitle("email")?> <br />
	<input type="text" name="email" value="" />
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

<?=include_js($BC->_getFolder('js').'custom/contact_us/send_form.js')?>