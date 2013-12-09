<div class="accountBox">
	<?=form_open($BC->_getBaseURL()."customers/signin")?>
		<div>
			<span><?=language('email')?>:</span>
			<?=form_input("email",'')?>
			<span><?=language('password')?>:</span>
			<?=form_password("password",'')?>
			
			<?=form_submit("submit",language('login'));?>

			<?=anchor_base('customers/register', language('register1'))?>
		</div>
	</form>
</div>