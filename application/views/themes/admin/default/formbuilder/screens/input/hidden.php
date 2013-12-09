<?if($BC->formbuilder_model->getFormMode()=='edit'):?>
    <?=form_hidden($BC->formbuilder_model->getInputName($item),$item['value'])?>
<?endif?>