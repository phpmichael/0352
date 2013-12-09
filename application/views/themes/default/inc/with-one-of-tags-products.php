<?
$tags = $BC->tags_model->getPostTagsStr($BC->_getCurrentTable(),$post_id);
$related_products = $BC->products_model->getWithOneOfTags($tags,3,@$exclude_ids);
?>

<?load_theme_view('inc/tpl-products-grid',$related_products);?>