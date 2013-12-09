<form action="<?=relative_url($BC->_getBaseURL()."/cart/add")?>" class="add-product">
    <?=form_hidden('id',$id)?>
    <?=language('price')?>: <?=exchange($price)?> 
    <?=br()?>
    <?if($in_stock):?>
    <?=language('quantity')?>: <?=form_input('qty',1,"size='1'")?>
    <?=br()?>
    <?=form_submit('',language('add_to_cart'))?>
    <?else:?>                         
    <p><?=language('not_in_stock')?></p>
    <?endif?>
    <?if(!is_product_in_wishlist($id)):?>
    <?=form_button('',language('add_to_wishlist'),"class='add-to-wishlist' id='add-to-wishlist-".$id."'")?>
    <?endif?>
    <!-- Attributes -->
	<?=((isset($attributes_list))?load_theme_view('inc/tpl-products-attributes-select',array('attributes_list'=>$attributes_list)):'')?>
<?=form_close()?>