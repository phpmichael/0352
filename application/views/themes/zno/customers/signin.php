
<h1 class="title"><?=$BC->_getPageTitle()?></h1>


<div class="well">
    <div id="errors"><?=validation_errors()?></div>

    <?=form_open($BC->_getBaseURI()."/signin",array('class'=>'form-inline'))?>
		<p>
			<span><?=language('email')?>:</span>
			<?=form_input("email",'',"class='input-medium'")?>

			<span><?=language('password')?>:</span>
			<?=form_password("password",'',"class='input-medium'")?>
			
			<?=form_submit('submit',language('login'),"class='btn'")?>
		</p>
		
		<p>
			<?=anchor($BC->_getBaseURI().'/forgot_pass', language('forgot_password'))?> | <?=anchor($BC->_getBaseURI().'/register', language('register1'))?>
		</p>
	</form>
</div>