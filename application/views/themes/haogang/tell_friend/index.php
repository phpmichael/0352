<div class="main-block">
    <div class="top-corners"><div><div>&nbsp;</div></div></div>

    <div class="corner">
        <div class="full-width">
            <div class="page-title">
                <h1><?=$BC->_getPageTitle()?></h1>
            </div>

            <p class="green" id="success"></p>
            <p class="red" id="errors"></p>
            
            <form id="tell_friend_form" action="#" method="post">
                <div class="fieldset">
                    <h2 class="legend"><?=language('contact_information')?></h2>

                    <p>
						<?=$BC->_getFieldTitle("name")?> <br />
						<input type="text" name="name" value="" size="70" />
					</p>
					<p>
						<?=$BC->_getFieldTitle("email")?> <br />
						<input type="text" name="email" value="" size="70" />
					</p>
					<p>
						<?=$BC->_getFieldTitle("friend_email")?> <br />
						<input type="text" name="friend_email" value="" size="70" />
					</p>
					<p>
						<?=$BC->_getFieldTitle("message")?> <br />
						<textarea name="message" class="textarea" rows="7" cols="71"></textarea>
					</p>
					
					<p><?=$cap_img?></p>
					<p>
						<?=$BC->_getFieldTitle("captcha")?>: <br />
						<input type="text" name="captcha" value="" />
					</p>
					                   
                </div>

                <div class="buttons-set">
                    <p class="required">* <?=language('required_fields')?></p>
                    
                    <button type="submit" title="Submit" class="button"><span><span><?=language('submit')?></span></span></button>
                </div>
            </form>
        </div>
    </div>

    <div class="bot-corners"><div><div>&nbsp;</div></div></div>
</div>
	
<?=include_js($BC->_getFolder('js').'custom/tell_friend/send_form.js')?>