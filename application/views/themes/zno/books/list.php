<h1><?=$BC->_getPageTitle()?></h1>

<p><?=nl2br(@$search_category_description)?></p>

<div id="find-book">
    <?
        $search_url = '';
        if( trim(urldecode(@$keywords)) ){
            $search_url .= 'keywords/'.$keywords;
        }
        elseif( trim(urldecode(@$manufacturer)) ){
            $search_url .= 'manufacturer/'.$manufacturer;
        }
        else{
            $search_url .= 'category'.url_category_addition();
        }

        $search_url .= '/display_style/'.$display_style;
        $search_url .= '/sort_by/'.$sort_by;
        $search_url .= '/sort_order/'.$sort_order;
    ?>
    <?=anchor_base('books/search/' . str_replace($display_style,'grid',$search_url) ,' ',"id='show-grid-icon'")?>
    <?=anchor_base('books/search/' . str_replace($display_style,'list',$search_url) ,' ',"id='show-list-icon'")?>
    <div class="pull-left">
        <?=language('sort_by')?>:
        <?=form_dropdown('sort_by',array(
            'priority'=>language('default'),
            'pub_date'=>language('publish_date'),
            'name'=>language('thing_name'),
            'price'=>language('price'),
            'views'=>language('popularity')),
        $sort_by,"style='width:160px'")?>

        <a href="javascript:void(0)" title="<?=language('sort_direction')?>" class="sort-direction" rel="<?if($sort_order=='asc'):?>desc<?else:?>asc<?endif?>">
            <img src="<?=base_url().$BC->_getTheme()?>img2/arrow-<?=$sort_order?>.png" class="v-middle" alt="" />
        </a>
    </div>
    <?if($paginate):?>
        <div class="pagination pull-right"><?=$paginate?></div>
    <?endif?>
    <div class="clearfix"></div>
</div>

<?if( $posts_list ):?>

    <div>
    <?if(in_array($display_style,array('list','grid'))):?>
        <?load_theme_view('inc/tpl-books-'.$display_style);?>
    <?endif?>
    </div>

    <?if($paginate):?>
        <div class="pagination pull-right"><p><?=language('page')?>: </p><?=$paginate?></div>
    <?endif?>

<?else:?>
    <h2><?=language('search_did_not_give_any_results')?></h2>
<?endif?>

<script>var search_url = '<?=site_url('books/search/' . $search_url)?>';</script>