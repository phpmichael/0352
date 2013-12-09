    <h2><?=language('catalog')?></h2>

    <div class="boxIndent list">
         <?=get_categories_tree('products',0,@$search_category_id,array('root_id'=>'products-categories'));?>
    </div>