<h2><?=$BC->_getPageTitle()?></h2>

<div id="products-categories-list">  	   
	<?foreach ($categories as $item):?>
		<p><?=anchor_base("{$controller}/index/category/".$item['id'],$item['category'],"class='category-name'")?></p>
		<p>
			<a title="<?=htmlspecialchars($item['category'])?>" href="<?=site_url($BC->_getBaseURL()."{$controller}/index/category/".$item['id'])?>" class="product-image">
				<?if(@$item['file_name']) echo img(array('src'=>'images/data/s/products_categories_list/'.$item['file_name'],'alt'=>htmlspecialchars($item['alt']),'width'=>$BC->settings_model['products_categories_list_small_width'],'height'=>$BC->settings_model['products_categories_list_small_height']))?>
			</a>
		</p>
		<?=nl2br($item['description'])?>
	<?endforeach;?>
</div>