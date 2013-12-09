<div <?if($item['html_id']):?>id='<?=$item['html_id']?>'<?endif?><?if($item['html_class']):?>class='<?=$item['html_class']?>'<?endif?>>

<?if($item['hide_label']=='no'):?>
<h2><?=$item['label']?></h2>
<?endif?>


<?if(stristr($item['template'],"/")):?>
	<?load_theme_view($item['template'])?>
<?elseif(isset($item['children'])):?>
    <?load_theme_view($BC->formbuilder_model->getScreensPath().'template/'.$item['template'],array('items'=>$item['children'],'parent'=>$item))?>
<?endif?>

</div>