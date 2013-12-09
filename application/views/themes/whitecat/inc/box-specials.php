<?$products_model = load_model('products_model');?>
<?$specials = $products_model->getSpecials(2);?>
<?if($specials['total_rows']):?>
<div class="module-specials">
    <h3><span><span><?=language('special_proposition')?></span></span></h3>

    <div class="boxIndent">
        <div class="wrapper">
            <table class="featuredLayout">
                <tbody>
                
                    <?foreach ($specials['posts_list'] as $row):?>
                    <tr>
                        <td width="50%" align="center">
                            <div class="featuredIndent">
                                <!-- The product image DIV. -->

                                <div class="product_image_container">
    		                        <a title="<?=htmlspecialchars($row->name)?>" href="<?=site_url($BC->_getBaseURL().'products/name/'.$row->slug.url_category_addition())?>">
    	                    			<?if(@$row->image) echo img('images/data/m/products/'.$row->image)?>
    	                    		</a>
    		                    </div><!-- END The product image DIV. -->

                                <div class="color">
                                    <div class="product-options">
                                        <!-- The product name DIV. -->

                                        <div>
    		                                <?=anchor_base('products/name/'.$row->slug.url_category_addition(),utf8_wordwrap($row->name,13,' '),"class='product_name'")?>
    		                            </div><!-- END The product name DIV. -->

                                        <div class="wrapper">
                                            <!-- The product price DIV. -->

                                            <div class="box_product_price">
                                                <span class="productPrice"><?=exchange($row->price)?></span> 
                                                <span class="product-Old-Price"><?=exchange($row->old_price)?></span>
                                            </div><!-- END The product price DIV. -->
                                            <!-- The product details DIV. -->
                                        </div>
                                    </div><!-- The product Description DIV. -->
                                    <!-- END The product Description DIV. -->
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?endforeach;?>
                    

                    <tr>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?endif?>