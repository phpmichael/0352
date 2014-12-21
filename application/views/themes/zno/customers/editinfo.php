<h1><?=$BC->_getPageTitle()?></h1>

<div class="well">
    <form id="registration_form" action="" method="post">
	    <?load_theme_view('inc/form-customer-info');?>
	    
	    <p>
            <?=form_submit('submit',language('save'),"class='btn'")?>
        </p>
	</form>
</div>