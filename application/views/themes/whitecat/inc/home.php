<div class="module-new">

    <h3><span><span><?=language('most_popular')?></span></span></h3>

    <div class="boxIndent">
        <div class="wrapper">
            <?$products_model = load_model('products_model');?>
    		<?load_theme_view('inc/tpl-products-grid',$products_model->getMostPopular(4));?>
        </div>
    </div>
    
    <br />
    
    <h3><span><span><?=language('novelty')?></span></span></h3>

    <div class="boxIndent">
        <div class="wrapper">
            <?$products_model = load_model('products_model');?>
    		<?load_theme_view('inc/tpl-products-grid',$products_model->getRecent(4));?>
        </div>
    </div>
    
    <br />
    
    <h3><span><span><?=language('featured')?></span></span></h3>

    <div class="boxIndent">
        <div class="wrapper">
            <?$products_model = load_model('products_model');?>
    		<?load_theme_view('inc/tpl-products-grid',$products_model->getFeatured(4));?>
        </div>
    </div>
    
    <br />
    
    <?if(trim($body)):?>
    <h3><span><span><?=language('about_us')?></span></span></h3>
    <div class="boxIndent">
        <div class="wrapper">
            <div class="content">
                <?=$body?>
            </div>
        </div>
    </div>
    <?endif?>
</div>

<?=load_inline_js('inc/js-add-to-cart'); ?>