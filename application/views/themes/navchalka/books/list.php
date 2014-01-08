<h1><?=$BC->_getPageTitle()?></h1>

<div id="find-book">
	<?fb_form("find_book",FALSE)?>
</div>

<?if( $posts_list ):?>
    
    <?if($paginate):?>
    <div class="pagination"><p><?=language('page')?>: </p><?=$paginate?></div>
    <?endif?>

    <div>
    <?if(in_array($display_style,array('list','grid'))):?>
        <?load_theme_view('inc/tpl-books-'.$display_style);?>
    <?endif?>
    </div>
    
    
    <?if($paginate):?>
    <div class="pagination"><p><?=language('page')?>: </p><?=$paginate?></div>
    <?endif?>

<?else:?>
    <h2><?=language('search_did_not_give_any_results')?></h2>
<?endif?>

<?$this->load->view('inc/js-add-to-cart'); ?>