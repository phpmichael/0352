<?//input type=hidden: add it without <li> tag?>
<?if($item['main_type']=='input' && $item['type']=='hidden' ):?>

	<?load_theme_view($BC->formbuilder_model->getScreensPath().'item',array('item'=>$item))?>

<?//input type=display and no value: don't show it?>	
<?elseif($item['main_type']=='input' && ($item['type']=='display' && !$item['value']) ):?>

<?//other: show it with  <li> tag?>
<?else:?>

    <li <?load_theme_view($BC->formbuilder_model->getTemplatePartsPath().'row_attr',array('item'=>$item,'parent'=>$parent,'col_num'=>$col_num))?>>
        <?load_theme_view($BC->formbuilder_model->getScreensPath().'item',array('item'=>$item))?>
    </li>

<?endif?>