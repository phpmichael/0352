<div class="module">
    <h3><span><span><?=language('articles')?></span></span></h3>

    <div class="boxIndent">
        <div class="wrapper">
            <div class="content">
                <?=get_categories_tree('articles',0,0,array('root_id'=>'articles-categories'));?>
            </div>
        </div>
    </div>
</div>