<ul>
    <?$col_num=0; foreach ($items as $item): $col_num++; ?>
    <?load_theme_view($BC->formbuilder_model->getTemplatePartsPath().'row',array('item'=>$item,'parent'=>$parent,'col_num'=>$col_num))?>
    <?if(!($col_num%$parent['columns'])):?><div style="clear:both"></div><?endif?>
    <?endforeach?>
</ul>