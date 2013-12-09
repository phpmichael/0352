<?if($item['value']):?>

<?load_theme_view($BC->formbuilder_model->getInputPartsPath().'label',array('item'=>$item))?>

<?load_theme_view($BC->formbuilder_model->getInputPartsPath().'div_open',array('item'=>$item))?>

    <?=$item['value']?>
	
</div>

<?endif?>