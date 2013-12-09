<?if($BC->formbuilder_model->getFormMode()=='edit'):?>
    <div style="text-align:<?=$item['align']?>">
    	<?=form_submit($item['name'],$item['label'],$BC->formbuilder_model->buildInputExtra($item))?>
    </div>
<?endif?>