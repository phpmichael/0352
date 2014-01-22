<div id="page">
    <h2 class="title"><span><span><?=$BC->_getPageTitle()?></span></span></h2>

    <div class="boxIndent">
        <div class="wrapper">
        
        	<?if(@$search_category_description):?>
	        	<div><?=nl2br($search_category_description)?></div>
	        	<hr class="separator-line" />
        	<?endif?>
        
            <?if( $posts_list ):?>
            
            	<div class="toolbar-top">
        	        <?load_theme_view('inc/tpl-products-toolbar');?>
        	    </div>
        	    
        	    <br class="clear" />
            
        	    <?if(in_array($display_style,array('list','grid'))):?>
                    <?load_theme_view('inc/tpl-products-'.$display_style);?>
                <?endif?>
                
                <br class="clear" />
                
                <div class="toolbar-bottom">
        	        <?load_theme_view('inc/tpl-products-toolbar');?>
        	    </div>
            
            <?else:?>
            <h2><?=language('search_did_not_give_any_results')?></h2>
            <br />
            <?endif?>
        </div>
    </div>
</div>

<?$this->load->view('inc/js-add-to-cart'); ?>

<script>
//<![CDATA[
$j(document).ready(function(){
    $j(".form-products-toolbar select").change(function(){
        $j(this).parents('form').submit();
    });
    
    $j(".sort-direction").click(function(){
    	$j(".form-products-toolbar input[name=sort_order]").val($j(".sort-direction").attr('rel'));
        $j(this).parents('form').submit();
    });
});
//]]>
</script>