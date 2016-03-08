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

                    <div itemscope itemtype="http://schema.org/Book" itemid="#book-<?=$row->data_key?>">
                        <link itemprop="additionalType" href="http://schema.org/Product"/>
                    
	                    <div class="product_image_container">
	                        <a title="<?=htmlspecialchars($row->name)?>" href="<?=site_url($BC->_getBaseURL().'book/'.$row->slug.url_category_addition())?>">
                    			<?if(@$row->photo1) echo img(array('src'=>'images/data/m/books/'.$row->photo1, 'height'=>'160', 'width'=>'?', 'alt'=>htmlspecialchars($row->name)))?>
                    		</a>
	                    </div>
	                    
	                    <div>

                            <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                <div class="product-price" itemprop="price" content="<?=exchange($row->price,FALSE)?>">
                                    <?=exchange($row->price)?>
                                </div>
                            </div>

                            <div>
                                <?if($row->in_stock):?>
                                     <?=form_submit('',language('buy'),"class='btn'")?>
                                <?else:?>
                                     <?=language('not_in_stock')?>
                                <?endif?>
                            </div>
                                
	                    </div
                    </div>
	
	             </form>
            </td>
            <td style="text-align:left;">
                <div itemscope itemtype="http://schema.org/Book" itemid="#book-<?=$row->data_key?>">
                
                    <h4 itemprop="name">
                        <?=anchor_base('book/'.$row->slug.url_category_addition(),$row->name,"class='product_name'")?>
                    </h4>

                    <p>
                        <strong>ISBN:</strong>
                        <span itemprop="isbn"><?=$row->ISBN?></span>
                    </p>

                    <?if($row->author):?>
                    <p>
                        <strong><?=fb_input_label("author","books")?>:</strong>
                        <span itemprop="author"><?=$row->author?></span>
                    </p>
                    <?endif?>

                    <?if($row->language):?>
                    <p>
                        <strong><?=fb_input_label("language","books")?>:</strong>
                        <span itemprop="inLanguage"><?=fb_answers($row->language)?></span>
                    </p>
                    <?endif?>

                    <?if($row->year):?>
                    <p>
                        <strong><?=fb_input_label("year","books")?>:</strong>
                        <span itemprop="datePublished"><?=$row->year?></span>
                    </p>
                    <?endif?>

                    <?if($row->number_of_pages):?>
                    <p>
                        <strong><?=fb_input_label("number_of_pages","books")?>:</strong>
                        <span itemprop="numberOfPages"><?=$row->number_of_pages?></span>
                    </p>
                    <?endif?>

                    <?if($row->cover):?>
                    <p><strong><?=fb_input_label("cover","books")?>:</strong> <?=fb_answers($row->cover)?></p>
                    <?endif?>
                </div>
            </td>
		</tr>
		<?endforeach;?>

</tbody>
</table>

<?endif?>