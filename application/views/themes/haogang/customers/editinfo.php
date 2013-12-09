<div class="main-block">
    <div class="top-corners"><div><div>&nbsp;</div></div></div>

    <div class="corner">
        <div class="full-width">
            <div class="page-title">
                <h1><?=$BC->_getPageTitle()?></h1>
            </div>

            <div class="red"><?=validation_errors()?></div>
            
            <?if(@$success_updated):?>
			<div class="green"><?=language('data_updated')?>.</div>
			<?endif?>
            
            <form id="registration_form" action="" method="post">
        		<div class="fieldset">
        			<h2 class="legend"><?=language('edit_my_info')?></h2>
        		
        		    <?load_theme_view('inc/form-customer-info');?>
        		</div>
        		
        		<div class="buttons-set">
        			<p class="required">* <?=language('required_fields')?></p>
        		
                    <button type="submit" title="Submit" class="button"><span><span><?=language('save')?></span></span></button>
                </div>
        	</form>
        </div>
    </div>

    <div class="bot-corners"><div><div>&nbsp;</div></div></div>
</div>