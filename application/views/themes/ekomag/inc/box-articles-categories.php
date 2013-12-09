    <h2><?=language('articles')?></h2>

    <div class="boxIndent list">
         <?=get_categories_tree('articles',0,0,array('root_id'=>'articles-categories'));?>
    </div>