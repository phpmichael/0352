<div class="toolbar">
    <?=form_open($BC->_getBaseURI()."/search",array('class'=>'form-products-toolbar'))?>
    <?=form_hidden('category[]',@$search_category_id)?>
    <?=form_hidden('sort_order',$sort_order)?>
    <?=form_hidden('keywords',trim(urldecode(@$keywords)))?>
    <?=form_hidden('tag',trim(urldecode(@$tag)))?>
    
        <?if(@trim(urldecode($keywords))):?>
        <div class="search-results-for">
            <h2><?=language('search_results_for')?>: " <i><?=trim(urldecode($keywords))?></i> "</h2>
        </div>
        <?elseif(@trim(urldecode($tag))):?>
        <div class="search-results-for">
            <h2><?=language('products_with_tag')?>: " <i><?=trim(urldecode($tag))?></i> "</h2>
        </div>
        <?endif?>
    
        <div class="pager">
            <p class="amount"><strong><?=language('items_count')?>: <?=$total_rows?></strong></p>
    
            <div class="limiter">
                <label><?=language('amount_per_page')?></label> 
                
                <?=form_dropdown('per_page',array(4=>4,6=>6,10=>10,20=>20),$per_page)?>
            </div>
        </div>
    
        <div class="sorter">
            <div class="pagination"><?=$paginate?></div>
    
            <div class="sort-by">
                <label><?=language('sort_by')?></label>
                <?=form_dropdown('sort_by',array('pub_date'=>language('publish_date'),'name'=>language('thing_name'),'price'=>language('price'),'views'=>language('popularity')),$sort_by)?>
                
                <a href="javascript:void(0)" title="<?=language('sort_direction')?>" class="sort-direction" rel="<?if($sort_order=='asc'):?>desc<?else:?>asc<?endif?>">
                    <img src="<?=base_url().$BC->_getTheme()?>images/i_<?=$sort_order?>_arrow.gif" class="v-middle" alt="" />
                </a>
                
            </div>
            <br class="clear" />
        </div>
    </form>
</div>