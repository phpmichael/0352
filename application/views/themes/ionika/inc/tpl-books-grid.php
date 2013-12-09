<?if($total_rows):?>
<div class="books-grid">
<table>
<tbody>
	<tr>
		<?$i=0; foreach ($posts_list as $row): $i++?>
		
		    <?if($i!=1 && !(($i-1)%4)):?></tr><tr><?endif?>
		
		        <td width="25%" class="grid-box">
		        	<form action="<?=relative_url($BC->_getBaseURL()."/cart/add")?>" class="add-product">
                        <?=form_hidden('id',$row->data_key)?>
                        <?=form_hidden('qty',1)?>
                        
		                    <div class="product_image_container">
		                        <a title="<?=htmlspecialchars($row->name)?>" href="<?=site_url($BC->_getBaseURL().'books/name/'.$row->slug.url_category_addition())?>">
	                    			<?if(@$row->photo1) echo img(array('src'=>'images/data/m/books/'.$row->photo1))?>
	                    		</a>
		                    </div><!-- END The product image DIV. -->
		
		                    <div class="color">
		                        <div class="product-options">
		                            <!-- The product name DIV. -->
		
		                            <div class="product_name">
		                                <?=anchor_base('books/name/'.$row->slug.url_category_addition(),utf8_wordwrap($row->name,17,' '),"class='product_name'")?>
		                            </div><!-- END The product name DIV. -->
		
		                            <div class="wrapper">
		                                <!-- The product price DIV. -->
		
		                                <div class="box_product_price">
		                                    <span class="productPrice"><?=exchange($row->price)?></span> 
		                                </div><!-- END The product price DIV. -->
		
		                                <!-- The add to cart DIV. -->
		
		                                <div>
		                                    <?if($row->in_stock):?>
		                                          <?=form_submit('',language('add_to_cart'))?>
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
		
		<?while($i%4):$i++?><td width="25%" class="grid-box"></td><?endwhile?>
	</tr>
</tbody>
</table>
</div>
<?endif?>