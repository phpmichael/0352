<h1 class="title" id="page-title"><?=$BC->_getPageTitle()?></h1>

<ul>
	<?foreach ($categories as $item):?>
	<li>
        <div class="fl" style="width:225px;"> 
            <div style="position:relative;">
				<a href="<?=site_url('assortment/index/category/'.$item['id'])?>">
                    <img src="<?=base_url()?>images/data/s/products_categories_list/<?=$item['file_name']?>" width="210" height="160" alt="<?=htmlspecialchars($item['alt'])?>" />
				    <div class="image-overlay"><div><span><?=$item['category']?></span></div></div>
                </a>
			</div>
        </div> 
        
        <div class="fl" style="width:700px;"><?=nl2br($item['description'])?></div>
        
        <div class="clear"></div>
	</li>
	<?endforeach;?>
</ul>

