<?$photos_categories_model = load_model('photos_categories_model')?>
<nav>
	<?=get_categories_tree('photos',0,@$search_category_id);?>
	<ul>
	    <li><a href="<?=site_url($BC->_getBaseUrl().'videos')?>"><?=language('videos')?></a></li>
	    <li><a href="<?=site_url($BC->_getBaseUrl().'contact_us')?>"><?=language('contacts')?></a></li>
	</ul>
</nav>