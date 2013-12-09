<?load_theme_view($BC->formbuilder_model->getInputPartsPath().'label',array('item'=>$item))?>

<?load_theme_view($BC->formbuilder_model->getInputPartsPath().'div_open',array('item'=>$item))?>

    <?if($BC->formbuilder_model->getFormMode()=='edit'):?>
    	<?=form_password($BC->formbuilder_model->getInputName($item),$item['value'],$BC->formbuilder_model->buildInputExtra($item))?>
    	<?=(isset($item['hint'])?$item['hint']:'')?>
    <?else:?>
		<?=$item['value']?>
	<?endif?>
	
</div>