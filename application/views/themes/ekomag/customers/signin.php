
    <h2><?=$BC->_getPageTitle()?></h2>

    <div class="boxIndent">
        <div id="errors"><?=validation_errors()?></div>
    
        <?=form_open($BC->_getBaseURI()."/signin")?>
    		<div class="fieldset">
    			<p>
    				<span><?=language('email')?>:</span>
    				<?=form_input("email",'',"class='input-text'")?>
    	
    				<span><?=language('password')?>:</span>
    				<?=form_password("password",'',"class='input-text'")?>
    				
    				<?=form_submit('submit',language('login'))?>
    			</p>
    			
    			<p>
    				<?=anchor($BC->_getBaseURI().'/forgot_pass', language('forgot_password'))?> | <?=anchor($BC->_getBaseURI().'/register', language('register1'))?>
    			</p>
    		</div>
    	</form>
    </div>
 