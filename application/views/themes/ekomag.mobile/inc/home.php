<ul data-role="listview" data-divider-theme="d" data-inset="false">
    <?if($BC->_getInterfaceLang()=='ru'):?>
        <li data-theme="a"><?=anchor_base('products/index/category/1','все для дома','id="menu-item1"'.( (preg_match('[/products/index/category/1\b]',$current_location_str))?' class="active" ':"" ))?></li>
        <li data-theme="a"><?=anchor_base('products/index/category/2','средства гигиены','id="menu-item2"'.( (preg_match('[/products/index/category/2\b]',$current_location_str))?' class="active" ':"" ))?></li>
        <li data-theme="a"><?=anchor_base('products/index/category/3','аромо терапия','id="menu-item3"'.( (preg_match('[/products/index/category/3\b]',$current_location_str))?' class="active" ':"" ))?></li>
        <li data-theme="a"><?=anchor_base('products/index/category/4','косме тика','id="menu-item4"'.( (preg_match('[/products/index/category/4\b]',$current_location_str))?' class="active" ':"" ))?></li>
        <li data-theme="a"><?=anchor_base('articles','видео статьи','id="menu-item5"'.( (preg_match('[/articles\b]',$current_location_str))?' class="active" ':"" ))?></li>
        <li data-theme="a"><?=anchor_base('faq','вопросы ответы','id="menu-item6"'.( (preg_match('[/faq\b]',$current_location_str))?' class="active" ':"" ))?></li>
        <li data-theme="a"><?=anchor('ru/page/kak-kupit','как купить','id="menu-item7"'.( (preg_match('[/kak-kupit\b]',$current_location_str))?' class="active" ':"" ))?></li>
    <?else:?>
        <li data-theme="a"><?=anchor_base('products/index/category/1','все для дому','id="menu-item1"'.( (preg_match('[/products/index/category/1\b]',$current_location_str))?' class="active" ':"" ))?></li>
        <li data-theme="a"><?=anchor_base('products/index/category/2','засоби гігієни','id="menu-item2"'.( (preg_match('[/products/index/category/2\b]',$current_location_str))?' class="active" ':"" ))?></li>
        <li data-theme="a"><?=anchor_base('products/index/category/3','аромо терапія','id="menu-item3"'.( (preg_match('[/products/index/category/3\b]',$current_location_str))?' class="active" ':"" ))?></li>
        <li data-theme="a"><?=anchor_base('products/index/category/4','косме тика','id="menu-item4"'.( (preg_match('[/products/index/category/4\b]',$current_location_str))?' class="active" ':"" ))?></li>
        <li data-theme="a"><?=anchor_base('articles','відео статті','id="menu-item5"'.( (preg_match('[/articles\b]',$current_location_str))?' class="active" ':"" ))?></li>
        <li data-theme="a"><?=anchor_base('faq','питання відповіді','id="menu-item6"'.( (preg_match('[/faq\b]',$current_location_str))?' class="active" ':"" ))?></li>
        <li data-theme="a"><?=anchor('page/yak-kupiti','як купити','id="menu-item7"'.( (preg_match('[/yak-kupiti\b]',$current_location_str))?' class="active" ':"" ))?></li>
    <?endif?>
</ul>