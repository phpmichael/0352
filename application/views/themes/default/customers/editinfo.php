<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<?php load_theme_view('inc/form-customer-info')?>

<p><?=form_submit("submit",language('save'));?></p>

</form>