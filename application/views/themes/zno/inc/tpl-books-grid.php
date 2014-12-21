<?if($total_rows):?>

<table class="table products-grid">
<tbody>
	<tr>
		<?$i=0; foreach ($posts_list as $row): $i++?>
		
		    <?if($i!=1 && !(($i-1)%3)):?></tr><tr><?endif?>
		
		        <td>
		        	<form action="<?=relative_url($BC->_getBaseURL()."/cart/add")?>" class="add-product">
                        <?=form_hidden('id',$row->data_key)?>
                        <?=form_hidden('qty',1)?>

                        <div class="product_image_container">
                            <a title="<?=htmlspecialchars($row->name)?>" href="<?=site_url($BC->_getBaseURL().'book/'.$row->slug.url_category_addition())?>">
                                <?if(@$row->photo1) echo img(array('src'=>'images/data/m/books/'.$row->photo1, 'height'=>'160', 'width'=>'?'))?>
                            </a>
                        </div>

                        <div class="product-title">
                            <?=anchor_base('book/'.$row->slug.url_category_addition(),$row->name,"class='product_name'")?>
                        </div>

                        <div class="product-buy">

                            <?if($row->in_stock):?>

                                <div class="product-price pull-left">
                                    <?=exchange($row->price)?>
                                </div>

                                <div class="pull-left">
                                    <?=form_button('','<i class="icon-shopping-cart"></i>'.language('buy'),"class='btn add-product-submit'")?>
                                    <?if(!is_product_in_wishlist($row->data_key)):?>
                                        <?=form_button('','<i class="icon-star"></i>',"class='add-to-wishlist btn' id='add-to-wishlist-".$row->data_key."'")?>
                                    <?endif?>
                                </div>
                            <?else:?>
                                <?=language('not_in_stock')?>
                            <?endif?>

                        </div>

		             </form>
	            </td>
		
		<?endforeach;?>
		
		<?while($i%2):$i++?><td></td><?endwhile?>
	</tr>
</tbody>
</table>

<?endif?>