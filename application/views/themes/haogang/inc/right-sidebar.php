<?load_theme_view('inc/box-cart');?>

<div class="block block-tags">
    <div class="main-block">
    
        <div class="top-corners"><div><div>&nbsp;</div></div></div>
        
        <div class="corner">
            <div class="full-width">
                <div class="block-title">
                    <strong><span><?=language('articles')?></span></strong>
                </div>
        
                <div class="block-content">
                    <div id="articles-categories">
                        <?=get_categories_tree('articles',0,0);?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bot-corners"><div><div>&nbsp;</div></div></div>

    </div>
</div>