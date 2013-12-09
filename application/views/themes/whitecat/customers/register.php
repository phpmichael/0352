<div id="page">
    <h2 class="title"><span><span><?=$BC->_getPageTitle()?></span></span></h2>

    <div class="boxIndent">
        <div class="wrapper">
            <div class="content">
                <p><?=anchor_base('customers/signin',language('already_registered').'? - '.language('login'))?></p>
            
                <p class="required">* <?=language('required_fields')?></p>
                <div id="errors"><?=validation_errors()?></div>
            
                <form id="registration_form" action="" method="post">
            		<div class="fieldset">
            		    <?load_theme_view('inc/form-customer-info');?>
    
    					<p><?=$cap_img?></p>
    					<p>
    						<?=$BC->_getFieldTitle('captcha');?>: <span class="red">*</span><br />
    						<input type="text" name="captcha" value="" class="required light-input" />
    					</p>
    					<p>
    					   <?=form_submit('submit',language('register1'))?>
    					</p>
            		</div>
            	</form>
            </div>
        </div>
    </div>
</div>