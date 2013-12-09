<div class="moduletable-categories">
    <div class="ddsmoothmenu" id="smoothmenu1">
        <div id="relative_div" style="position:relative;z-index:0"></div>
        <ul class="level1">
            <li class="level1">
                <a href="<?=base_url().$BC->_getBaseURL()?>"><?=language('home_page')?></a>
            </li>
            <li class="level1">
                <?=anchor_base('products',language('catalog'))?>
                <?=get_categories_tree('products',0,0,array('start_level'=>2));?>
            </li>
            <li class="level1">
                <?=anchor_base('articles',language('articles'))?>
                <?=get_categories_tree('articles',0,0,array('start_level'=>2));?>
            </li>
            <?=get_menu('left')?>
        </ul>
    </div>
</div>