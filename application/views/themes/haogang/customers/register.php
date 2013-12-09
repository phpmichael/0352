<div class="main-block">
    <div class="top-corners"><div><div>&nbsp;</div></div></div>

    <div class="corner">
        <div class="full-width">
            <div class="page-title">
                <h1><?=$BC->_getPageTitle()?></h1>
            </div>

            <div class="red"><?=validation_errors()?></div>
            
            <form id="registration_form" action="" method="post">
        		<div class="fieldset">
        			<h2 class="legend"><?=language('register')?></h2>
        		
        		    <?load_theme_view('inc/form-customer-info');?>

					<p><?=form_checkbox("subscribe",1,true)?> <?=language('subscribe')?></p>
					
					<p><?=$cap_img?></p>
					<p>
						<?=$BC->_getFieldTitle('captcha');?>: <span class="red">*</span><br />
						<input type="text" name="captcha" value="" class="required" />
					</p>
        		</div>
        		
        		<div class="buttons-set">
        			<p class="required">* <?=language('required_fields')?></p>
        			
                    <button type="submit" title="Submit" class="button"><span><span><?=language('register1')?></span></span></button>
                </div>
        	</form>
        </div>
    </div>

    <div class="bot-corners"><div><div>&nbsp;</div></div></div>
</div>