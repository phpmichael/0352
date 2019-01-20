<div>
    <ul id="products-categories">
    <?
        $categoriesMenu = $BC->products_categories_model->getChildren(0,true);
        foreach ($categoriesMenu as $categoryMenuItem)
        {
            $active = (@$search_category_id === $categoryMenuItem['id']) ? " class='active'" : "";
            $categoryMenuItemSlug = $categoryMenuItem['slug'] ? $categoryMenuItem['slug'] : $categoryMenuItem['id'];
            ?>
            <li>
                <?=anchor_base("books/search/category/{$categoryMenuItemSlug}", '<i class="cat-without-children"></i> '.$categoryMenuItem['category'], $active)?>
            </li>
            <?
        }
    ?>
    </ul>
</div>