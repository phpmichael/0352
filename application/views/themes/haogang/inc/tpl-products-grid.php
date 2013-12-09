<?if($total_rows):?>
<?$i=0; foreach ($posts_list as $row): $i++?>

    <?if($i%2):?><ul class="products-grid"><li class="item first"><?else:?><li class="item last"><?endif?>

        <div class="main-block">
        
            <div class="top-corners"><div><div>&nbsp;</div></div></div>

            <div class="corner">
                <div class="full-width">
                    <div class="product-box">
                        <div class="ie-fix">
                        
                            <form action="<?=relative_url($BC->_getBaseURL()."/cart/add")?>" class="add-product">
                                <?=form_hidden('id',$row->id)?>
                                <?=form_hidden('qty',1)?>

                                <a title="<?=htmlspecialchars($row->name)?>" href="<?=site_url($BC->_getBaseURL().'products/name/'.$row->slug.url_category_addition())?>" class="product-image">
                        			<?if(@$row->image) echo img('images/data/m/products/'.$row->image)?>
                        		</a>

                                <div class="product-details">
                                    <h2 class="product-name a-center">
                                        <?=anchor_base('products/name/'.$row->slug.url_category_addition(),$row->name)?>
                                    </h2>
                                    <div class="actions">
                                        <?if($row->in_stock):?>
                                            <button type="submit" title="<?=language('add_to_cart')?>" class="button btn-cart">
                                                <span><span><?=language('add_to_cart')?></span></span>
                                            </button>
                                        <?else:?>
	                                         <div style="text-align:center"><?=language('not_in_stock')?></div>
	                                    <?endif?>
    
                                        <div class="price-box">
                                            <span class="regular-price">
                                                <span class="price"><?=exchange($row->price)?></span>
                                            </span>
                                        </div>
    
                                        <div class="clear"></div>
    
                                        
                                        <ul class="add-to-links">
                                            <li>
                                            <?if(!is_product_in_wishlist($row->id)):?>
                                                <a href="javascript:void(0)" class="link-wishlist add-to-wishlist" id='add-to-wishlist-<?=$row->id?>'><?=language('add_to_wishlist')?></a>
                                            <?endif?> 
                                            </li>
                                        </ul>
                                        <br class="clear" />
                                        
                                    </div>
                                </div>
                                <br class="clear" />
                             </form>
                             
                        </div>
                    </div>
                </div>
            </div>

            <div class="bot-corners"><div><div>&nbsp;</div></div></div>
        </div>
        
    <?if(!($i%2)):?></li></ul><?else:?></li><?endif?>

<?endforeach;?>

<?if($i%2):?></li></ul><?endif?>
<?endif?>