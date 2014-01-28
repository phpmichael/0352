<!DOCTYPE html>
<html>
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