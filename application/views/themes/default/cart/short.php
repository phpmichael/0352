<?if($this->cart->total_items()):?>

	<h3><?=language('shopping_cart')?></h3>
	
	<div><?=$this->cart->total_items()?> <?=language($items_in_cart_lang_code)?></div>
	<div><?=language('total')?>: <?=exchange($this->cart->total())?></div>
	<div><?=anchor($BC->_getBaseURI(),language('show'))?></div>
	<?else:?>
	<div><?=language('your_cart_is_empty')?></div>

<?endif?>