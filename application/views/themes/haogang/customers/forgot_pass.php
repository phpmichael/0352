<div class="main-block">
    <div class="top-corners"><div><div>&nbsp;</div></div></div>

    <div class="corner">
        <div class="full-width">
            <div class="page-title">
                <h1><?=$BC->_getPageTitle()?></h1>
            </div>

            <div class="red"><?=validation_errors()?></div>
            
            <?if(@$success_sent):?>
			<div class="green"><?=language('password_sent_on_your_email')?></div>
			<?endif?>
            
            <div id="accountBox">
				<?=form_open($BC->_getBaseURI()."/forgot_pass")?>
					<div>	
						<p>
							<span><?=language('email')?>:</span>
							<?=form_input("email",'')?>
						</p>
					</div>
					
					<div class="buttons-set">
	                    <button type="submit" title="Submit" class="button"><span><span><?=language('submit')?></span></span></button>
	                </div>
				</form>
			</div>
        </div>
    </div>

    <div class="bot-corners"><div><div>&nbsp;</div></div></div>
</div>