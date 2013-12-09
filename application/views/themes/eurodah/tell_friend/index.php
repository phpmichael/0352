<div class="section">

    <h1 class="title" id="page-title"><?=$BC->_getPageTitle()?></h1>

    <div id="block-system-main">
        <div class="content">
            <div class="required">* <?=language('required_fields')?></div>
            <br />
            
            <div class="green" id="success"></div>
            <div class="red" id="errors"></div>
            
            <form id="tell_friend_form" action="#" method="post">
                <div class="fieldset">
                    <div>
                    	<label><?=$BC->_getFieldTitle("name")?> <span class="required">*</span></label>
                    	<input type="text" name="name" value="" size="70" class="form-text" />
                    </div>
                    <div>
                    	<label><?=$BC->_getFieldTitle("email")?> <span class="required">*</span></label>
                    	<input type="text" name="email" value="" size="70" class="form-text" />
                    </div>
                    <div>
                    	<label><?=$BC->_getFieldTitle("friend_email")?> <span class="required">*</span></label>
                    	<input type="text" name="friend_email" value="" size="70" class="form-text" />
                    </div>
                    <div>
                    	<label><?=$BC->_getFieldTitle("message")?> <span class="required">*</span></label>
                    	<textarea name="message" rows="7" cols="73" class="form-text"></textarea>
                    </div>
                    
                    <div>
                    	<label><?=$BC->_getFieldTitle("captcha")?> <span class="required">*</span></label>
                    	<div>
                    	   <div style="float:left;"><?=$cap_img?></div> 
                    	   <div style="float:left;margin-left:10px;"><input type="text" name="captcha" value="" class="form-text" /></div>
                    	   <div style="clear:both;"></div> 
                        </div>
                    </div>
                    
                    <div>
                        <?=form_submit('submit',language('submit'),"class='form-submit'")?>
                    </div>
                   
                </div>
            </form>
        </div>
    </div>
    
</div>


<?=include_js($BC->_getFolder('js').'custom/tell_friend/send_form.js')?>