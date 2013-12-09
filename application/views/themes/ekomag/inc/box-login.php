    <h2><?=language('login_form')?></h2>

    <div class="boxIndent">
        <?=form_open($BC->_getBaseURL()."customers/signin")?>
            <strong><?=language('email')?>:</strong> <?=form_input("email")?>

            <strong><?=language('password')?>:</strong> <?=form_password("password")?>
            
            <?=form_submit('submit',language('login'))?>

            <?=anchor_base('customers/forgot_pass', language('forgot_password'))?>
            <?=anchor_base('customers/register', language('register1'))?>
        </form>
    </div>