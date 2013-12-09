<?
$item['alt'] = 'time';
$item['value'] = substr($item['value'],0,5);
?>
<?load_theme_view($BC->formbuilder_model->getScreensPath().'input/text',array('item'=>$item))?>