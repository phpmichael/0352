
    <h2><?=$BC->_getPageTitle()?></h2>

    <div class="boxIndent">
        <table width="100%">
        <tr>
            <td width="50%" class="vt">
                <?if(@$image):?>
                <div style="position:relative;">
                <?if($old_price!=0.00):?><div class="product-tag product-tag-superprice"></div><?endif?>
            	<a href="<?=base_url().'images/data/b/products/'.$image?>" class="product-image">
            		<?=img('images/data/m/products/'.$image)?>
            	</a>
            	</div>
            	<?endif?>
            </td>
            <td width="50%" class="vt">
        		<form method="post" action="<?=relative_url($BC->_getBaseURL()."/cart/add")?>" class="add-product">
                    <?=form_hidden('id',$id)?>

                    <div class="actions">
                        
                        <div class="price-box">
                            <?if($old_price!=0.00):?>
                            <span class="product-Old-Price"><?=exchange($old_price)?></span>
                            <?endif?>
                        </div>
                        
                        <?if($in_stock):?>
                        
                            <?=language('quantity')?>: <?=form_input('qty',1,"size='1' style='width:20px;'")?>
                        
                            <?$tmpPriceArr = explode('.',$price)?>
                              <div class="buy-btn">
                              	<div class="buy-btn-price">
                              		<span class="numeric-price"><?=$tmpPriceArr[0]?></span><span class="decimal-price">.<?=$tmpPriceArr[1]?> грн.</span>
                              	</div>
                              	<div class="buy-btn-submit"><?=form_submit('','')?></div>
                              </div>
                            
                            <p>&nbsp;</p>
                            
                            <!-- Attributes -->
                            <?load_theme_view('inc/tpl-products-attributes-select',array('attributes_list'=>$attributes_list))?>
                            
                            <!-- Manudacturer -->
                            <?if($manufacturer):?>
                                <p><strong><?=language('manufacturer')?>: <?=$manufacturer?></strong></p>
                            <?endif?>
                        
                        <?else:?>
                        
                        	<p><?=language('not_in_stock')?></p>
                        
                        <?endif?>

                        <?if(!is_product_in_wishlist($id)):?>
                        <ul class="add-to-links">
                            <li><a href="javascript:void(0)" class="link-wishlist add-to-wishlist" id='add-to-wishlist-<?=$id?>'><?=language('add_to_wishlist')?></a></li>
                        </ul>
                        <?endif?>
                        
                        <p><?social_buttons()?></p>
                        
                        <p><a href="javascript:void(0)" class="request-call"><?=language('request_a_call')?></a></p>
                        
                    </div>
                 </form>
        	</td>
        </tr>
        <?if(!empty($additional_images)):?>
        <tr>
            <td colspan="2">
                <?foreach ($additional_images as $additional_image):?>
            	   <a style="width:80px;height:80px;display:block;float:left;margin:3px;" class="product-image" href="<?=base_url().'images/data/b/'.$BC->_getCurrentTable().'/'.$additional_image['image']?>"><?=img('images/data/s/'.$BC->_getCurrentTable().'/'.$additional_image['image'])?></a>
            	<?endforeach?>
            </td>
        </tr>
        <?endif?>
        </table>
        
        <?if(@($description)):?>
            <?=$description?>
        <?endif?>
        
        <?if(@($youtube_url)):?>
        <p>
            <?=youtube_box($youtube_url)?>
        </p>
        <?endif?>
        
        <?load_theme_view('inc/box-rate',array('post_id'=>$id,'rating'=>$rating,'already_rated'=>$already_rated,'table'=>$BC->_getCurrentTable()));?>
        
        <?load_theme_view('inc/box-post-tags',array('post_id'=>$id));?>
        
        <h3><?=language('similar_products')?></h3>
        
        <?load_theme_view('inc/with-one-of-tags-products',array('post_id'=>$id,'exclude_ids'=>$id));?>
        
        <br />
        
        <?
		    //show comments
		    
		    $sub_data['post_id'] = $id;
		    $sub_data['table'] = $BC->_getCurrentTable();
		    
		    load_theme_view('inc/comments',$sub_data)
		?>
    </div>



<?=load_inline_js('inc/js-add-to-cart'); ?>