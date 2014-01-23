<div class="std">
    <div class="clear"></div>
</div>

<div class="home-block">

    <a href="#"><img src="<?=base_url().$BC->_getTheme()?>images/home_banner_1.jpg" class="home-banner-1" alt="" /></a>

    <?load_theme_view('inc/box-short-cart');?>
    
    <a href="#"><img src="<?=base_url().$BC->_getTheme()?>images/home_banner_2.jpg" class="home-banner-2" alt="" /></a>
    
    <br class="clear" />
    
</div>

<div class="home-products">
    <div class="page-title">
        <h2 class="subtitle"><?=language('most_popular')?></h2>
    </div>

    <?$products_model = load_model('products_model');?>
    
    <?load_theme_view('inc/tpl-products-grid',$products_model->getMostPopular(6));?>
</div>

<?=load_inline_js('inc/js-add-to-cart'); ?>
<?=load_inline_js('inc/js-tooltip'); ?>