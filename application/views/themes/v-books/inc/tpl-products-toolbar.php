<div>

 <?=form_open($BC->_getBaseURI()."/search",array('class'=>'form-products-toolbar'))?>
    <?if(@$search_category_id) echo form_hidden('category[]',$search_category_id)?>
    <?if(@$sort_order) echo form_hidden('sort_order',$sort_order)?>
    <?if(@$keywords) echo form_hidden('keywords',trim(urldecode($keywords)))?>
    <?if(@$tag) echo form_hidden('tag',trim(urldecode($tag)))?>
    <?if(@$manufacturer) echo form_hidden('manufacturer',trim(urldecode($manufacturer)))?>

    <?if(@trim(urldecode($keywords))):?>
    <div class="search-results-for">
        <h4><?=language('search_results_for')?>: " <i><?=trim(urldecode($keywords))?></i> "</h4>
    </div>
    <?elseif(@trim(urldecode($tag))):?>
    <div class="search-results-for">
        <h4><?=language('products_with_tag')?>: " <i><?=trim(urldecode($tag))?></i> "</h4>
    </div>
    <?elseif(@trim(urldecode($manufacturer))):?>
    <div class="search-results-for">
        <h4><?=language('manufacturer')?>: " <i><?=trim(urldecode($manufacturer))?></i> "</h4>
    </div>
    <?endif?>

    <div class="clearfix">
        <div class="span4">
            <label class="inline"><?=language('sort_by')?>:</label>
        	<?=form_dropdown('sort_by',array('pub_date'=>language('publish_date'),'name'=>language('thing_name'),'price'=>language('price'),'views'=>language('popularity')),$sort_by,"class='input-medium'")?>
            <a href="javascript:void(0)" title="<?=language('sort_direction')?>" class="sort-direction" rel="<?if($sort_order=='asc'):?>desc<?else:?>asc<?endif?>">
                <i class="icon-chevron-<?if($sort_order=='asc'):?>up<?else:?>down<?endif?>"></i>
            </a>
        </div>
        
        <div class="span4">
            <label><?=language('products_amount')?>:</label>        
            <?=$total_rows?>
        </div>
        
        <div class="span4">
            <label><?=language('amount_per_page')?>:</label>        
            <?=form_dropdown('per_page',array(9=>9,12=>12,15=>15,18=>18,21=>21),$per_page,"class='input-mini'")?>
        </div>
    </div>  

</form>

</div>