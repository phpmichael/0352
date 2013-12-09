
    <h2><?=$BC->_getPageTitle()?></h2>

    <div class="boxIndent">
        
        <form id="registration_form" action="" method="post">
    		<div class="fieldset">
    		    <?load_theme_view('inc/form-customer-info');?>
    		    
    		    <p>
                    <?=form_submit('submit',language('save'))?>
                </p>
    		</div>
    	</form>
    </div>
