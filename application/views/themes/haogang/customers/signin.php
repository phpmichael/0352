<div class="main-block">
    <div class="top-corners"><div><div>&nbsp;</div></div></div>

    <div class="corner">
        <div class="full-width">
            <div class="page-title">
                <h1><?=$BC->_getPageTitle()?></h1>
            </div>

            <div class="red"><?=validation_errors()?></div>
            
            <?=form_open($BC->_getBaseURI()."/signin")?>
        		<div class="fieldset">
        		    <h2 class="legend"><?=language('please_login')?></h2>
        			<p>
        				<span><?=language('email')?>:</span>
        				<?=form_input("email",'',"class='input-text'")?>
        	
        				<span><?=language('password')?>:</span>
        				<?=form_password("password",'',"class='input-text'")?>
        			</p>
        			
        			<p>
        			    <br/>&nbsp;
        				<?=anchor($BC->_getBaseURI().'/forgot_pass', language('forgot_password'))?> | <?=anchor($BC->_getBaseURI().'/register', language('register1'))?>
        			</p>
        		</div>
        		
        		<div class="buttons-set">
                    <button type="submit" title="Submit" class="button"><span><span><?=language('login')?></span></span></button>
                </div>
        	</form>
        </div>
    </div>

    <div class="bot-corners"><div><div>&nbsp;</div></div></div>
</div>