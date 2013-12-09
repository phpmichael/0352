<h2><?=language('catalog')?></h2>

<div class="well">
     <?=get_categories_tree('books',0,@$search_category_id,array('root_id'=>'products-categories','link_title_prefix_without_children'=>'<i class="icon-chevron-right"></i> ','link_title_prefix_with_children'=>'<i class="icon-chevron-down"></i> '));?>
</div>