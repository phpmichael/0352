<?if($search_category_id == 1):?>
    <?load_theme_view('categories/top-category');?>
<?else:?>

    <h1><?=$BC->_getPageTitle()?></h1>

    <div class="category-grid">
        <?foreach ($categories as $item):?>
            <div class="category-grid-item">
                <p>
                    <?=anchor_base("{$controller}/index/category/".$item['id'],$item['category'])?>
                </p>

                <?if(@$item['file_name']):?>
                <p>
                    <a title="<?=htmlspecialchars($item['category'])?>" href="<?=site_url($BC->_getBaseURL()."{$controller}/index/category/".$item['id'])?>">
                        <?=img('images/data/s/products_categories_list/'.$item['file_name'])?>
                    </a>
                </p>
                <?endif?>
            </div>
        <?endforeach;?>
    </div>

<?endif?>
