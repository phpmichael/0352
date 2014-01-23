<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
    <title><?=$BC->formbuilder_model->getFormTitle($form_id)?></title>

	<?=include_css('css/zero.css')?>
	<?=load_inline_js('inc/js-jquery'); ?>
	
	<?=include_css('css/fb/styles.css');?>
</head>
<body>

	<?fb_form($form_id,$data_key)?>

</body>
</html>