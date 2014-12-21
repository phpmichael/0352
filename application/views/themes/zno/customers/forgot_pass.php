<h1><?=$BC->_getPageTitle()?></h1>

<div class="well">
    <?if(@$success_sent):?>
	<p class="green"><?=language('password_sent_on_your_email')?></p>
	<?endif?>
	
	<div id="errors"><?=validation_errors()?></div>
    
	<?=form_open($BC->_getBaseURI()."/forgot_pass")?>
		<p>
			<span><?=language('email')?>:</span>
			<?=form_input("email",'')?>
		</p>
		
		<p>
            <?=form_submit('submit',language('submit'),"class='btn'")?>
        </p>
	</form>
</div>