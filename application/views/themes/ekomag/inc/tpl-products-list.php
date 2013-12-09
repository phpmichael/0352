<?$BC->load->helper('text')?>
<?if($total_rows):?>
<div class="products-list">
<table>
<tbody>

		<?$i=0; foreach ($posts_list as $row): $i++?>
		<tr>
	        <td width="30%" class="grid-box">
	        	<form method="post" action="<?=relative_url($BC->_getBaseURL()."/cart/add")?>" class="add-product">
                    <?=form_hidden('id',$row->id)?>
                    <?=form_hidden('qty',1)?>
                    
	                    <div class="product_image_container">
	                    	<?if($row->old_price!=0.00):?><div class="product-tag product-tag-superprice"></div><?endif?>
	                        <a title="<?=htmlspecialchars($row->name)?>" href="<?=site_url($BC->_getBaseURL().'products/name/'.$row->slug.url_category_addition())?>">
                    			<?if(@$row->image) echo img(array('src'=>'images/data/m/products/'.$row->image,'alt'=>htmlspecialchars($row->alt),'width'=>$BC->settings_model['products_medium_width'],'height'=>$BC->settings_model['products_medium_height']))?>
                    		</a>
	                    </div>
	
	                    <div class="color">
	                        <div class="product-options">

	                            <div class="wrapper">
	                                
	                                <div>
                                        <?if($row->old_price!=0.00):?>
                                        <span class="product-Old-Price"><?=exchange($row->old_price)?></span>
                                        <?else:?>
                                        &nbsp;
                                        <?endif?>
	                                </div>
	
	                                
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
	                                </div>
	                            </div>
	                        </div>
	                        
	                    </div>
	             </form>
            </td>
            <td width="70%" class="grid-box" style="text-align:justify;">
                
                <div class="product_name">
                    <?=anchor_base('products/name/'.$row->slug.url_category_addition(),$row->name,"class='product_name'")?>
                </div>
            
                <?=word_limiter_more($row->description, 80, '')?>
            </td>
		</tr>
		<?endforeach;?>

</tbody>
</table>
</div>
<?endif?>