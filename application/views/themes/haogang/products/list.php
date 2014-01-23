<div class="page-title category-title">
    <h1><?=$BC->_getPageTitle()?></h1>
</div>

<div class="category-products">
    <?if( $posts_list ):?>
    
    	<div class="toolbar-top">
	        <?load_theme_view('inc/tpl-products-toolbar');?>
	    </div>
	    
	    <br class="clear" />
    
        <?load_theme_view('inc/tpl-products-grid');?>
        
        <div class="toolbar-bottom">
	        <?load_theme_view('inc/tpl-products-toolbar');?>
	    </div>
    
    <?else:?>
    <h2><?=language('search_did_not_give_any_results')?></h2>
    <?endif?>
</div>

<?=load_inline_js('inc/js-add-to-cart'); ?>
<?=load_inline_js('inc/js-tooltip'); ?>

<script>
$j(document).ready(function(){
    $j(".form-products-toolbar select").change(function(){
        $j(this).parents('form').submit();
    });
    
    $j(".sort-direction").click(function(){
    	$j(".form-products-toolbar input[name=sort_order]").val($j(".sort-direction").attr('rel'));
        $j(this).parents('form').submit();
    });
});
</script>