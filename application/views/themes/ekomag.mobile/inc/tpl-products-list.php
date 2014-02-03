<?if($total_rows):?>
<div class="products-list">
	<?foreach ($posts_list as $row):?>
        <div>
        	<form method="post" action="<?=relative_url($BC->_getBaseURL()."/cart/add")?>" class="add-product">
                <?=form_hidden('id',$row->id)?>
                <?=form_hidden('qty',1)?>
                
                	<p>
	                    <?=anchor_base('products/name/'.$row->slug.url_category_addition(),$row->name,"class='product-name'")?>
	                </p>
                
                    <p class="product-image" data-lightbox="product-image">
                        <a title="<?=htmlspecialchars($row->name)?>" href="<?=site_url($BC->_getBaseURL().'products/name/'.$row->slug.url_category_addition())?>">
                			<?if(@$row->image) echo img(array('src'=>'images/data/m/products/'.$row->image,'alt'=>htmlspecialchars($row->alt),'width'=>$BC->settings_model['products_medium_width'],'height'=>$BC->settings_model['products_medium_height']))?>
                		</a>
                    </p>

                    <p class="product-price"><?=exchange($row->price)?></p>
                    
                    <p class="product-old-price"><?if($row->old_price!=0.00):?><?=exchange($row->old_price)?><?endif?></p>
                    
                    <p><?=form_submit('add_to_cart',language('add_to_cart'))?></p>
             </form>
        </div>
	<?endforeach;?>
</div>
<?endif?>