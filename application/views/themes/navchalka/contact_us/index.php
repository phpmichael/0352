<h1><?=$BC->_getPageTitle()?></h1>

<div class="well">
    <?
	   $contact_page = $BC->pages_model->getByLink('contact_us');
	   echo $contact_page['body'];
	?>

    <p class="required">* <?=language('required_fields')?></p>
    <div class="green" id="success"></div>
    <div class="red" id="errors"></div>
    
    <form id="contact_form" action="#" method="post">
            <p>
            	<?=$BC->_getFieldTitle("name")?> <br />
            	<input type="text" name="name" value="" size="70" class="input-large" />
            </p>
            <p>
            	<?=$BC->_getFieldTitle("email")?> <br />
            	<input type="text" name="email" value="" size="70" class="input-large" />
            </p>
            <p>
            	<?=$BC->_getFieldTitle("message")?> <br />
            	<textarea name="message" rows="7" cols="71" class="input-large"></textarea>
            </p>
            
            <p><?=$cap_img?><br />&nbsp;</p>
            <p>
            	<?=$BC->_getFieldTitle("captcha")?>: <br />
            	<input type="text" name="captcha" value="" class="input-large" />
            </p>
            
            <p>
                <?=form_submit('submit',language('submit'),"class='btn'")?>
            </p>
    </form>
</div>

<?=include_js($BC->_getFolder('js').'custom/contact_us/send_form.js')?>