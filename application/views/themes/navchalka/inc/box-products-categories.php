<div class="catalog">
    <div class="catalog-top"></div>
    <?
        if ( !($categories_tree = $BC->cache->get('categories_tree')) )
        {
            $categories_tree = get_categories_tree(
                'books',
                0,
                @$search_category_id,
                array(
                    'root_id' => 'products-categories',
                    'link_title_prefix_without_children' => '<i class="cat-without-children"></i> ',
                    'link_title_prefix_with_children' => '<i class="cat-with-children"></i> '
                )
            );
            $BC->cache->save('categories_tree', $categories_tree, 5*60);
        }
        echo $categories_tree;
    ?>
    <div class="catalog-bottom"></div>
</div>