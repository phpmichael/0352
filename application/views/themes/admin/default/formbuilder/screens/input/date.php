<?
$item['alt'] = 'date';
if($item['value']=='0000-00-00') $item['value'] = '';
elseif($item['value']) $item['value'] = date('d/m/Y',strtotime($item['value']));
?>
<?load_theme_view($BC->formbuilder_model->getScreensPath().'input/text',array('item'=>$item))?>