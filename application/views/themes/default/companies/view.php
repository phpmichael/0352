<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<p><?load_theme_view('inc/tpl-company-preview')?></p>

<?if(@$image):?>
<p><?=img('images/data/b/companies/'.$image)?></p>
<?endif?>

<p><?=nl2br($short_description)?></p>

<hr />

<?if($long_description):?>
	<?=$long_description?>
	<hr />
<?endif?>

<?if(isset($post_categories)):?>
<?load_theme_view('inc/box-post-categories',array('post_categories'=>$post_categories,'method'=>'search'));?>
<?endif?>

<h3><?=language('products_and_services')?>:</h3>

<p><?=preg_replace_callback("#([^\n]+)(\n|$)#", function ($matches) use ($BC) {
    $service = $matches[1];
    return anchor($BC->_getBaseURI().'/search/keywords/'.urlencode(trim($service)), htmlspecialchars($service)).'<br/>';
}, (string) $services)?></p>

<hr />

<p><?=language('views_count')?>: <?=$views?></p>

<?=load_inline_js('inc/js-paint-fields-vals')?>