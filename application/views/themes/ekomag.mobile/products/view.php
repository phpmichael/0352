<h2><?=$BC->_getPageTitle()?></h2>

<div>

	<?if(@$image):?>
	<p class="product-image">
		<a href="<?=base_url().'images/data/b/products/'.$image?>">
			<?=img('images/data/m/products/'.$image)?>
		</a>
	</p>
	<?endif?>
	
	<form method="post" action="<?=relative_url($BC->_getBaseURL()."/cart/add")?>" class="add-product">
		<?=form_hidden('id',$id)?>
		<?=form_hidden('qty',1)?>
		
		<p class="product-price"><?=exchange($price)?></p>
		
		<p class="product-old-price"><?if($old_price!=0.00):?><?=exchange($old_price)?><?endif?></p>
		    
		<?if($in_stock):?>
		    <p><?=form_submit('add_to_cart',language('add_to_cart'))?></p>
		<?else:?>
			<p><?=language('not_in_stock')?></p>
		<?endif?>
	</form>
	
	<p><?social_buttons()?></p>
	
	<?if(@($description)):?>
	<?=$description?>
	<?endif?>
	
	<?load_theme_view('inc/box-rate',array('post_id'=>$id,'rating'=>$rating,'already_rated'=>$already_rated,'table'=>$BC->_getCurrentTable()));?>
	
	<?load_theme_view('inc/box-post-tags',array('post_id'=>$id));?>
	
	<br />
	
	<?
	//show comments
	
	$sub_data['post_id'] = $id;
	$sub_data['table'] = $BC->_getCurrentTable();
	
	load_theme_view('inc/comments',$sub_data)
	?>
</div>

<?$this->load->view('inc/js-add-to-cart'); ?>        