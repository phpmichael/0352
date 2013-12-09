<div id="page">
    <h2 class="title"><span><span><?=$BC->_getPageTitle()?></span></span></h2>

    <div class="boxIndent">
        <div class="wrapper">
            <div class="content">
                <p class="required">* <?=language('required_fields')?></p>
                <div class="green" id="success"></div>
                <div class="red" id="errors"></div>
                
                <form id="contact_form" action="#" method="post">
                    <div class="fieldset">
                        <p>
                        	<?=$BC->_getFieldTitle("name")?> <br />
                        	<input type="text" name="name" value="" size="70" class="light-input" />
                        </p>
                        <p>
                        	<?=$BC->_getFieldTitle("email")?> <br />
                        	<input type="text" name="email" value="" size="70" class="light-input" />
                        </p>
                        <p>
                        	<?=$BC->_getFieldTitle("message")?> <br />
                        	<textarea name="message" rows="7" cols="71" class="light-input"></textarea>
                        </p>
                        
                        <p><?=$cap_img?><br />&nbsp;</p>
                        <p>
                        	<?=$BC->_getFieldTitle("captcha")?>: <br />
                        	<input type="text" name="captcha" value="" class="light-input" />
                        </p>
                        
                        <p>
                            <?=form_submit('submit',language('submit'))?>
                        </p>
                       
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?=include_js($BC->_getFolder('js').'custom/contact_us/send_form.js')?>