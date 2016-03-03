<?$loc_length = @count($current_location_arr); $i=0;?>
<ul class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
    <?foreach ($current_location_arr as $loc_url=>$loc_title): $i++;?>
        <?$loc_url = str_replace('products','books',$loc_url);?>
        <?if($i == $loc_length):?>
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="javascript:;" class="active">
                    <span itemprop="name"><?=$loc_title?></span>
                </a>
                <meta itemprop="position" content="<?=$i?>" />
            </li>
        <?else:?>
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="<?=site_url($loc_url)?>">
                    <span itemprop="name"><?=$loc_title?></span>
                </a>
                <span class="divider">/</span>
                <meta itemprop="position" content="<?=$i?>" />
            </li>
        <?endif?>
    <?endforeach;?>
</ul>