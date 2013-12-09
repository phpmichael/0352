<?load_theme_view($BC->formbuilder_model->getInputPartsPath().'label',array('item'=>$item))?>

<?load_theme_view($BC->formbuilder_model->getInputPartsPath().'div_open',array('item'=>$item))?>

	<?if($BC->formbuilder_model->getFormMode()=='edit'):?>
    	<?=form_textarea($BC->formbuilder_model->getInputName($item),$item['value'],$BC->formbuilder_model->buildInputExtra($item))?>
    	<?=(isset($item['hint'])?$item['hint']:'')?>
    <?else:?>
		<?=(($item['type']=='richtext')?$item['value']:nl2br($item['value']))?>
    <?endif?>
    
</div>