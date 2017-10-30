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

                        <div itemscope itemtype="http://schema.org/Book">
                            <link itemprop="additionalType" href="http://schema.org/Product"/>

                            <div class="product_image_container">
                                <a title="<?=htmlspecialchars($row->name)?>" href="<?=site_url($BC->_getBaseURL().'book/'.$row->slug.url_category_addition())?>">
                                    <?if(@$row->photo1) echo img(array('data-src'=>'images/data/m/books/'.$row->photo1, 'height'=>'160', 'width'=>'?', 'alt'=>htmlspecialchars($row->name)))?>
                                </a>
                            </div>

                            <div class="product-title" itemprop="name">
                                <?=anchor_base('book/'.$row->slug.url_category_addition(),$row->name,'class="product_name"')?>
                            </div>

                            <div class="product-buy">

                                <?if($row->in_stock):?>

                                    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                        <div class="product-price pull-left" itemprop="price" content="<?=exchange($row->price,FALSE)?>">
                                            <?=exchange($row->price)?>
                                        </div>
                                    </div>

                                    <div class="pull-left">
                                        <?=form_button('add_to_cart','<i class="icon-shopping-cart"></i>'.language('buy'),"class='btn add-product-submit'")?>
                                    </div>
                                <?else:?>
                                    <?=language('not_in_stock')?>
                                <?endif?>

                            </div>
                        </div>

		             </form>
	            </td>
		
		<?endforeach;?>
		
		<?while($i%2):$i++?><td></td><?endwhile?>
	</tr>
</tbody>
</table>

<?endif?>