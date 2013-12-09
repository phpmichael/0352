<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<div class="clear"></div>

<h3><?=language('categories')?> | <?=anchor_base("{$controller}/search",language('search'))?> </h3>

<?foreach ($categories as $item):?>

<p><?=anchor_base("{$controller}/index/category/".$item['id'],$item['category'],"class='big grey'")?></p>

<?endforeach;?>