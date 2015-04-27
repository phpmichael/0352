<h2><?=$BC->_getPageTitle()?></h2>

<?foreach ($categories as $item):?>

    <p>
        <?=anchor_base("{$controller}/index/category/".$item['id'],$item['category'])?>
    </p>

    <?if(@$item['file_name']):?>
        <p>
            <a title="<?=htmlspecialchars($item['category'])?>" href="<?=site_url($BC->_getBaseURL()."{$controller}/index/category/".$item['id'])?>">
                <?=img('images/data/s/quiz_categories_list/'.$item['file_name'])?>
            </a>
        </p>
    <?endif?>

<?endforeach;?>