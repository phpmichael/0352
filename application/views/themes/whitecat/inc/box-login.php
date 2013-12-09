<div class="module_LoginForm">
    <h3><span><span><?=language('login_form')?></span></span></h3>

    <div class="boxIndent">
        <div class="wrapper">
            <?=form_open($BC->_getBaseURL()."customers/signin")?>
                <div class="part1">
                    <div class="wrapper">
                        <div class="username">
                            <span><?=language('email')?></span> <?=form_input("email",'','class="inputbox" id="mod_login_username"')?>
                        </div>

                        <div class="password">
                            <span><?=language('password')?></span> <?=form_password("password",'','class="inputbox" id="mod_login_password"')?>
                        </div>
                    </div>

                    <div id="inputs">
                        <input type="submit" name="Submit" class="button" value="<?=language('login')?>" />

                        <div id="form-login-remember">
                            <?=anchor_base('customers/forgot_pass', language('forgot_password'))?>
                        </div>
                    </div><?=anchor_base('customers/register', language('register1'), "class='reg'")?>
                </div>
            </form>
        </div>
    </div>
</div>