<?$photos_categories_model = load_model('photos_categories_model')?>
<nav>
	<ul>
	    <li><a href="<?=site_url($BC->_getBaseUrl().'photos/index/1')?>"><?=$photos_categories_model->getTitle(1)?></a>
	        <ul>
	            <li><a href="<?=site_url($BC->_getBaseUrl().'photos/show/3')?>"><?=$photos_categories_model->getTitle(3)?></a></li>
	            <li><a href="<?=site_url($BC->_getBaseUrl().'photos/show/4')?>"><?=$photos_categories_model->getTitle(4)?></a></li>
	            <li><a href="<?=site_url($BC->_getBaseUrl().'photos/show/5')?>"><?=$photos_categories_model->getTitle(5)?></a></li>
	            <li><a href="<?=site_url($BC->_getBaseUrl().'photos/show/6')?>"><?=$photos_categories_model->getTitle(6)?></a></li>
	        </ul>
	    </li>
	    <li><a href="<?=site_url($BC->_getBaseUrl().'photos/index/2')?>"><?=$photos_categories_model->getTitle(2)?></a>
	        <ul>
	            <li><a href="<?=site_url($BC->_getBaseUrl().'photos/show/7')?>"><?=$photos_categories_model->getTitle(7)?></a></li>
	            <li><a href="<?=site_url($BC->_getBaseUrl().'photos/show/8')?>"><?=$photos_categories_model->getTitle(8)?></a></li>
	            <li><a href="<?=site_url($BC->_getBaseUrl().'photos/show/9')?>"><?=$photos_categories_model->getTitle(9)?></a></li>
	            <li><a href="<?=site_url($BC->_getBaseUrl().'photos/show/10')?>"><?=$photos_categories_model->getTitle(10)?></a></li>
	            <li><a href="<?=site_url($BC->_getBaseUrl().'photos/show/11')?>"><?=$photos_categories_model->getTitle(11)?></a></li>
	        </ul>
	    </li>
	    <li><a href="<?=site_url($BC->_getBaseUrl().'videos')?>"><?=language('videos')?></a></li>
	    <li><a href="<?=site_url($BC->_getBaseUrl().'contact_us')?>"><?=language('contacts')?></a></li>
	</ul>
</nav>