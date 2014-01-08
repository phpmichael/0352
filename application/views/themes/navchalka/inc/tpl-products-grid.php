<?if($total_rows):?>

<table class="table table-bordered table-striped products-grid">
<tbody>
	<tr>
		<?$i=0; foreach ($posts_list as $row): $i++?>
		
		    <?if($i!=1 && !(($i-1)%2)):?></tr><tr><?endif?>
		
		        <td width="50%">
		        	<form action="<?=relative_url($BC->_getBaseURL()."/cart/add")?>" class="add-product">
                        <?=form_hidden('id',$row->id)?>
                        <?=form_hidden('qty',1)?>
                        
		                    <div class="product_image_container">
		                        <a title="<?=htmlspecialchars($row->name)?>" href="<?=site_url($BC->_getBaseURL().'product/'.$row->slug.url_category_addition())?>">
	                    			<?if(@$row->image) echo img(array('src'=>'images/data/m/products/'.$row->image))?>
	                    		</a>
		                    </div>
		
		                    <div>
		
	                            <div>
	                                <?=anchor_base('product/'.$row->slug.url_category_addition(),utf8_wordwrap($row->name,17,' '),"class='product_name'")?>
	                            </div>
	
	                            <div class="product-price">
                                    <?=exchange($row->price)?>
                                </div>

                                <div>
                                    <?if($row->in_stock):?>
                                         <?=form_submit('',language('buy'),"class='btn btn-primary'")?>
                                    <?else:?>
                                         <?=language('not_in_stock')?>
                                    <?endif?>
                                </div>
	                                
		                    </div>
		             </form>
	            </td>
		
		<?endforeach;?>
		
		<?while($i%2):$i++?><td width="50%"></td><?endwhile?>
	</tr>
</tbody>
</table>

<?endif?>