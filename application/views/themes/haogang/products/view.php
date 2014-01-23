<div class="main-block">
    <div class="top-corners"><div><div>&nbsp;</div></div></div>

    <div class="corner">
        <div class="full-width">
            <div class="product-view">
                <div class="page-title">
                    <h1><?=$BC->_getPageTitle()?></h1>
                </div>
    
                <table class="data-table">
                <tr>
                    <td width="50%">
                        <?if(@$image):?>
                    	<a style="width:118px;height:118px;display:block;" href="<?=base_url().'images/data/b/products/'.$image?>" class="product-image">
                    		<?=img('images/data/m/products/'.$image)?>
                    	</a>
                    	<?endif?>
                    </td>
                    <td width="50%">
                		<form action="<?=relative_url($BC->_getBaseURL()."/cart/add")?>" class="add-product">
                            <?=form_hidden('id',$id)?>
    
                            <div class="actions">
                                
                                <div class="price-box">
                                    <span class="regular-price">
                                        <span class="price"><?=exchange($price)?></span>
                                    </span>
                                </div>
                                
                                <?if($in_stock):?>
                                
	                                <?=form_input('qty',1,"size='1'")?>
	                            
	                                <button type="submit" title="<?=language('add_to_cart')?>" class="button btn-cart">
	                                    <span><span><?=language('add_to_cart')?></span></span>
	                                </button>
	                                
	                                <p>&nbsp;</p>
	                                
	                                <!-- Attributes -->
	                                <?=load_theme_view('inc/tpl-products-attributes-select',array('attributes_list'=>$attributes_list))?>
	                                
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
                                
                            </div>
                         </form>
                	</td>
                </tr>
                <?if(!empty($additional_images)):?>
                <tr>
                    <td colspan="2">
                        <?foreach ($additional_images as $additional_image):?>
                    	   <a style="width:65px;height:65px;display:block;float:left;margin:3px;" class="product-image" href="<?=base_url().'images/data/b/'.$BC->_getCurrentTable().'/'.$additional_image['image']?>"><?=img('images/data/s/'.$BC->_getCurrentTable().'/'.$additional_image['image'])?></a>
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
                
                <?load_theme_view('inc/box-post-tags',array('post_id'=>$id));?>
            </div>
		</div>
    </div>

    <div class="bot-corners"><div><div>&nbsp;</div></div></div>
</div>


<?=load_inline_js('inc/js-add-to-cart'); ?>
<?=load_inline_js('inc/js-tooltip'); ?>

<?=load_inline_js('inc/js-lightbox'); ?>