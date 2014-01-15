<div class="side-box">
    <div class="side-box-top">
        <h3 class="catalog"><?=language('catalog')?></h3>
    </div>
    <?
        echo get_categories_tree(
            'books',
            0,
            @$search_category_id,
            array(
                'root_id' => 'products-categories',
                'link_title_prefix_without_children' => '<i class="cat-without-children"></i> ',
                'link_title_prefix_with_children' => '<i class="cat-with-children"></i> ',
                'cache_time' => 5*60
            )
        );
    ?>
    <div class="side-box-bottom"></div>
</div>