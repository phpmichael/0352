<h1><?=$BC->_getPageTitle()?></h1>

<?if( $posts_list ):?>

	<div class="well">
        <?load_theme_view('inc/tpl-products-toolbar');?>
    </div>

    <div class="well">
        <?load_theme_view('inc/tpl-products-grid');?>
    </div>
    
    <div class="well">
        <?load_theme_view('inc/tpl-products-toolbar');?>
    </div>

<?else:?>
    <h2><?=language('search_did_not_give_any_results')?></h2>
<?endif?>

<?$this->load->view('inc/js-add-to-cart'); ?>

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