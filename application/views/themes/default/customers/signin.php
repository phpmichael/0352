<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<div class="accountBox">
	<?=form_open($BC->_getBaseURI()."/signin")?>
		<div>
			<p>
				<span><?=language('email')?>:</span>
				<?=form_input("email",'')?>
	
				<span><?=language('password')?>:</span>
				<?=form_password("password",'')?>
			</p>
			
			<p>
				<?=form_submit("submit",language('login'));?>

				<?=anchor($BC->_getBaseURI().'/forgot_pass', language('forgot_password'))?> | <?=anchor($BC->_getBaseURI().'/register', language('register1'))?>
			</p>
		</div>
	</form>
</div>

<div class="red"><?=validation_errors()?></div>