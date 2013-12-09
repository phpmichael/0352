
    <h2><?=$BC->_getPageTitle()?></h2>

    <div class="boxIndent">
        <?if(@$success_sent):?>
		<p class="green"><?=language('password_sent_on_your_email')?></p>
		<?endif?>
		
		<div id="errors"><?=validation_errors()?></div>
        
        <div id="accountBox">
			<?=form_open($BC->_getBaseURI()."/forgot_pass")?>
				<div>	
					<p>
						<span><?=language('email')?>:</span>
						<?=form_input("email",'')?>
					</p>
					
					<p>
                        <?=form_submit('submit',language('submit'))?>
                    </p>
				</div>
			</form>
		</div>
    </div>
