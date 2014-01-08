<div class="well">
    <?=form_open($BC->_getBaseURL()."customers/signin")?>
        <span><?=language('email')?></span> <?=form_input("email",'')?>
        
        <span><?=language('password')?></span> <?=form_password("password",'')?>

        <?=anchor_base('customers/forgot_pass', language('forgot_password'))?>

        <input type="submit" name="Submit" class="btn btn-primary" value="<?=language('login')?>" />
         
        <?=anchor_base('customers/register', language('register1'))?>
    </form>
</div>