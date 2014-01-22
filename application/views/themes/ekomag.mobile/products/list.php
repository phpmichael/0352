<h2><?=$BC->_getPageTitle()?></h2>

<div>
    <?if( $posts_list ):?>
    
    	<div class="toolbar-top">
	        <?load_theme_view('inc/tpl-products-toolbar');?>
	    </div>
	    
	    <br class="clear" />
    
	    <?if(in_array($display_style,array('list','grid'))):?>
            <?load_theme_view('inc/tpl-products-list');?>
        <?endif?>
        
        <br class="clear" />
        
        <div class="toolbar-bottom">
	        <?load_theme_view('inc/tpl-products-toolbar');?>
	    </div>
 		
    <?else:?>
    	<h2><?=language('search_did_not_give_any_results')?></h2>
    <?endif?>
</div>

<?$this->load->view('inc/js-add-to-cart'); ?>

<script>

$j(document).ready(function(){
    $j(".sort-by").click(function(){
    	$j(".form-products-toolbar input[name=sort_by]").val($j(this).attr('rel'));
        $j(this).parents('form').submit();
    });
    
    $j(".sort-direction").click(function(){
    	$j(".form-products-toolbar input[name=sort_order]").val($j(this).attr('rel'));
        $j(this).parents('form').submit();
    });
});

</script>