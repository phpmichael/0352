<?$BC->load->helper('text')?>
<?if($total_rows):?>

<table class="table table-bordered table-striped">
<tbody>

		<?$i=0; foreach ($posts_list as $row): $i++?>
		<tr>
	        <td width="160px" style="text-align:center;">
	        	<form method="post" action="<?=relative_url($BC->_getBaseURL()."/cart/add")?>" class="add-product">
                    <?=form_hidden('id',$row->data_key)?>
                    <?=form_hidden('qty',1)?>
                    
	                    <div class="product_image_container">
	                        <a title="<?=htmlspecialchars($row->name)?>" href="<?=site_url($BC->_getBaseURL().'book/'.$row->slug.url_category_addition())?>">
                    			<?if(@$row->photo1) echo img(array('src'=>'images/data/m/books/'.$row->photo1, 'height'=>'160', 'width'=>'?'))?>
                    		</a>
	                    </div>
	                    
	                    <div>

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
                                
	                    </div
	
	             </form>
            </td>
            <td style="text-align:left;">
                
                <h4>
                    <?=anchor_base('book/'.$row->slug.url_category_addition(),$row->name,"class='product_name'")?>
                </h4>
            
                <p><strong>ISBN:</strong> <?=$row->ISBN?></p>
                    
                <?if($row->author):?>
                <p><strong><?=fb_input_label("author","books")?>:</strong> <?=$row->author?></p>
                <?endif?>
                
                <?if($row->language):?>
                <p><strong><?=fb_input_label("language","books")?>:</strong> <?=fb_answers($row->language)?></p>
                <?endif?>
                
                <?if($row->year):?>
                <p><strong><?=fb_input_label("year","books")?>:</strong> <?=$row->year?></p>
                <?endif?>
                
                <?if($row->number_of_pages):?>
                <p><strong><?=fb_input_label("number_of_pages","books")?>:</strong> <?=$row->number_of_pages?></p>
                <?endif?>
                
                <?if($row->cover):?>
                <p><strong><?=fb_input_label("cover","books")?>:</strong> <?=fb_answers($row->cover)?></p>
                <?endif?> 
            </td>
		</tr>
		<?endforeach;?>

</tbody>
</table>

<?endif?>