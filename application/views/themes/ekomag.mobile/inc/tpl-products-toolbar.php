<?=form_open($BC->_getBaseURI()."/search/category/".@$search_category_id,array('class'=>'form-products-toolbar'))?>
	<?=form_hidden('category[]',@$search_category_id)?>
    <?=form_hidden('sort_by',$sort_by)?>
    <?=form_hidden('sort_order',$sort_order)?>
    <?=form_hidden('keywords',trim(urldecode(@$keywords)))?>
    <?=form_hidden('tag',trim(urldecode(@$tag)))?>

    <div>
        <label><?=language('sort_by')?>:</label>
    	
    	<?if($sort_by=='pub_date'):?><?=language('publish_date')?><?else:?><a href="javascript:;" class="sort-by" rel="pub_date"><?=language('publish_date')?></a><?endif?> | 
    	<?if($sort_by=='name'):?><?=language('thing_name')?><?else:?><a href="javascript:;" class="sort-by" rel="name"><?=language('thing_name')?></a><?endif?> | 
    	<?if($sort_by=='price'):?><?=language('price')?><?else:?><a href="javascript:;" class="sort-by" rel="price"><?=language('price')?></a><?endif?> | 
    	<?if($sort_by=='views'):?><?=language('popularity')?><?else:?><a href="javascript:;" class="sort-by" rel="views"><?=language('popularity')?></a><?endif?>
    </div>	
    <div>	
    	<label><?=language('sort_direction')?>:</label>
    	<a href="javascript:;" title="<?=language('sort_direction')?>" class="sort-direction" rel="<?if($sort_order=='asc'):?>desc<?else:?>asc<?endif?>">
            <img src="<?=base_url().$BC->_getTheme()?>images/<?=$sort_order?>_arrow.png" alt="" />
        </a>
    </div>
    

    <?if($paginate):?>
    <div class="pagination"><p><?=language('page')?>: </p><?=$paginate?></div>
    <?endif?>
    
    <div class="clear"></div>

</form>