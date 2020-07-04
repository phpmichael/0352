<h1><?=$search_category_description?></h1>

<ul>
    <?foreach ($categories as $item): ?>
        <li style="font-size: 130%; line-height: 150%;">
            <?=anchor_base("{$controller}/index/category/".$item['id'],$item['category'])?>
        </li>
    <?endforeach;?>
</ul>