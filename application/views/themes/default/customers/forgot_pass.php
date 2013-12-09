<?load_theme_view('inc/tpl-cur-location'); ?>

<h2><?=$BC->_getPageTitle()?></h2>

<div id="accountBox">
	<?=form_open($BC->_getBaseURI()."/forgot_pass")?>
		<div>	
			<p>
				<span><?=language('email')?>:</span>
				<?=form_input("email",'')?>
			</p>
			
			<p>
				<?=form_submit("submit",language('submit'));?>
			</p>
		</div>
	</form>
</div>

<div class="red"><?=validation_errors()?></div>

<?if(@$success_sent):?>
<div class="green"><?=language('password_sent_on_your_email')?></div>
<?endif?>