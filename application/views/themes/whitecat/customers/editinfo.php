<div id="page">
    <h2 class="title"><span><span><?=$BC->_getPageTitle()?></span></span></h2>

    <div class="boxIndent">
        <div class="wrapper">
            <div class="content">
                <?if(@$success_updated):?>
    			<p class="green"><?=language('data_updated')?>.</p>
    			<?endif?>
            
                <p class="required">* <?=language('required_fields')?></p>
                <div class="errors"><?=validation_errors()?></div>
                
                <br />
                
                <form id="registration_form" action="" method="post">
            		<div class="fieldset">
            		    <?load_theme_view('inc/form-customer-info');?>
            		    
            		    <p>
                            <?=form_submit('submit',language('save'))?>
                        </p>
            		</div>
            	</form>
            </div>
        </div>
    </div>
</div>