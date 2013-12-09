<h3><?=language('login_form')?></h3>

<div class="well">
    <?=form_open($BC->_getBaseURL()."customers/signin")?>
        <span><?=language('email')?></span>&nbsp;&nbsp; <?=form_input("email",'')?>
        
        <span><?=language('password')?></span> <?=form_password("password",'')?>

        <input type="submit" name="Submit" class="btn" value="<?=language('login')?>" />

        <?=anchor_base('customers/forgot_pass', language('forgot_password'))?>
         
        <?=anchor_base('customers/register', language('register1'))?>
    </form>
</div>