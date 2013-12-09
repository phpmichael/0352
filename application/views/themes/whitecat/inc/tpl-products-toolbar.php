<div class="orderby_form">

 <?=form_open($BC->_getBaseURI()."/search",array('class'=>'form-products-toolbar'))?>
    <?=form_hidden('category[]',@$search_category_id)?>
    <?=form_hidden('sort_order',$sort_order)?>
    <?=form_hidden('keywords',trim(urldecode(@$keywords)))?>
    <?=form_hidden('tag',trim(urldecode(@$tag)))?>

    <?if(@trim(urldecode($keywords))):?>
    <div class="search-results-for">
        <h4><?=language('search_results_for')?>: " <i><?=trim(urldecode($keywords))?></i> "</h4>
    </div>
    <?elseif(@trim(urldecode($tag))):?>
    <div class="search-results-for">
        <h4><?=language('products_with_tag')?>: " <i><?=trim(urldecode($tag))?></i> "</h4>
    </div>
    <?endif?>

    <div class="float-left">
        <label><?=language('sort_by')?>:</label>
    	<?=form_dropdown('sort_by',array('pub_date'=>language('publish_date'),'name'=>language('thing_name'),'price'=>language('price'),'views'=>language('popularity')),$sort_by)?>
        <a href="javascript:void(0)" title="<?=language('sort_direction')?>" class="sort-direction" rel="<?if($sort_order=='asc'):?>desc<?else:?>asc<?endif?>">
            <img src="<?=base_url().$BC->_getTheme()?>images/<?=$sort_order?>_arrow.png" alt="" />
        </a>
    </div>
    
    <div class="float-left">
        &nbsp;
        <label><?=language('products_amount')?>:</label>        
        <?=$total_rows?>
        &nbsp;
        <label><?=language('amount_per_page')?>:</label>        
        <?=form_dropdown('per_page',array(4=>4,12=>12,16=>16,20=>20,24=>24),$per_page)?>
    </div>
    

    <?if($paginate):?>
    <div class="pagination"><p><?=language('page')?>: </p><?=$paginate?></div>
    <?endif?>
    
    <div class="clear"></div>

</form>

</div>