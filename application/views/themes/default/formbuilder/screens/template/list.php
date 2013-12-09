<ul>
    <?foreach ($items as $item):?>
    <?load_theme_view($BC->formbuilder_model->getTemplatePartsPath().'row',array('item'=>$item,'parent'=>$parent,'col_num'=>0))?>
    <?endforeach?>
</ul>