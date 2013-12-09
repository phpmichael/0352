<?if($total_rows):?>
<div class="products-grid">
<table>
<tbody>
	<tr>
		<?$i=0; foreach ($posts_list as $row): $i++?>
		
		    <?if($i!=1 && !(($i-1)%3)):?></tr><tr><?endif?>
		
		        <td width="33%" class="grid-box">
		        	<form method="post" action="<?=relative_url($BC->_getBaseURL()."/cart/add")?>" class="add-product">
                        <?=form_hidden('id',$row->id)?>
                        <?=form_hidden('qty',1)?>
                        
		                    <div class="product_image_container">
		                    	<?if($row->old_price!=0.00):?><div class="product-tag product-tag-superprice"></div><?endif?>
		                        <a title="<?=htmlspecialchars($row->name)?>" href="<?=site_url($BC->_getBaseURL().'products/name/'.$row->slug.url_category_addition())?>">
	                    			<?if(@$row->image) echo img(array('src'=>'images/data/m/products/'.$row->image,'alt'=>htmlspecialchars($row->alt),'width'=>$BC->settings_model['products_medium_width'],'height'=>$BC->settings_model['products_medium_height']))?>
	                    		</a>
		                    </div><!-- END The product image DIV. -->
		
		                    <div class="color">
		                        <div class="product-options">
		                            <!-- The product name DIV. -->
		
		                            <div class="product_name">
		                                <?=anchor_base('products/name/'.$row->slug.url_category_addition(),$row->name,"class='product_name'")?>
		                            </div><!-- END The product name DIV. -->
		
		                            <div class="wrapper">
		                                <!-- The product price DIV. -->
		
		                                <div>
                                            <?if($row->old_price!=0.00):?>
                                            <span class="product-Old-Price"><?=exchange($row->old_price)?></span>
                                            <?else:?>
                                            &nbsp;
                                            <?endif?>
		                                </div><!-- END The product price DIV. -->
		
		                                <!-- The add to cart DIV. -->
		
		                                <div class="add-to-cart-button">
		                                    <?if($row->in_stock):?>
	                                    	  <?$tmpPriceArr = explode('.',$row->price)?>
			                                  <div class="buy-btn">
			                                  	<div class="buy-btn-price">
			                                  		<span class="numeric-price"><?=$tmpPriceArr[0]?></span><span class="decimal-price">.<?=$tmpPriceArr[1]?> грн.</span>
			                                  	</div>
			                                  	<div class="buy-btn-submit"><?=form_submit('','')?></div>
			                                  </div>
		                                    <?else:?>
		                                    	<?=language('not_in_stock')?>
		                                    <?endif?>
		                                </div><!-- END The add to cart DIV. -->
		                            </div>
		                        </div><!-- The product Description DIV. -->
		                        <!-- END The product Description DIV. -->
		                    </div>
		             </form>
	            </td>
		
		<?endforeach;?>
		
		<?while($i%3):$i++?><td width="33%" class="grid-box"></td><?endwhile?>
	</tr>
</tbody>
</table>
</div>
<?endif?>