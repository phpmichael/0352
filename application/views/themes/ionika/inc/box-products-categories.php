<div class="module">
    <h3><span><span><?=language('catalog')?></span></span></h3>

    <div class="boxIndent">
        <div class="wrapper">
            <div class="content">
                <?=get_categories_tree('products',0,0,array('root_id'=>'products-categories'));?>
            </div>
        </div>
    </div>
</div>