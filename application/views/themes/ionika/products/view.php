<div id="page">
    <h1 class="title"><span><span><?=$BC->_getPageTitle()?></span></span></h1>

    <div class="boxIndent">
        <div class="wrapper">
            <div class="content">
                <table>
                <tr>
                    <td width="50%">
                        <div class="product_image_container">
                            <?if(@$image):?>
                        	<a href="<?=base_url().'images/data/b/products/'.$image?>" class="product-image" data-lightbox="product-image">
                        		<?=img(array('src'=>'images/data/b/products/'.$image, 'width'=>350))?>
                        	</a>
                        	<?endif?>
                        </div>
                    </td>
                    <td width="50%">
                		<form action="<?=relative_url($BC->_getBaseURL()."/cart/add")?>" class="add-product">
                            <?=form_hidden('id',$id)?>
    
                            <div class="actions">
                                
                                <div class="price-box">
                                    <span class="productPrice"><?=exchange($price)?></span>
                                    <?if($old_price!=0.00):?>
                                    <span class="product-Old-Price"><?=exchange($old_price)?></span>
                                    <?endif?>
                                </div>
                                
                                <?if($in_stock):?>
                                
	                                <?=form_input('qty',1,"size='1'")?>
	                            
	                                <button type="submit" title="<?=language('add_to_cart')?>" class="button btn-cart">
	                                    <span><span><?=language('add_to_cart')?></span></span>
	                                </button>
	                                
	                                <div style="height:10px"></div>
	                                
	                                <!-- Attributes -->
	                                <?load_theme_view('inc/tpl-products-attributes-select',array('attributes_list'=>$attributes_list))?>
	                                
	                                <!-- Manudacturer -->
                                    <?if($manufacturer):?>
                                        <p><strong><?=language('manufacturer')?>: <?=anchor_base('products/search/manufacturer/'.urlencode($manufacturer),$manufacturer)?></strong></p>
                                    <?endif?>
                                
                                <?else:?>
                                
                                	<p><?=language('not_in_stock')?></p>
                                
                                <?endif?>
                                
                                <?load_theme_view('inc/box-social-buttons')?>
                                
                                <p>
                                	<?if($BC->_getInterfaceLang()=='ua'):?>
                                		<?=anchor($BC->_getBaseURL().'contact_us',"Не влаштовує ціна чи знайшли дешевше? <br/> Напишіть нам, і ми постараємося знайти вирішення.")?>
                                	<?else:?>
                                		<?=anchor($BC->_getBaseURL().'contact_us',"Не устраивает цена или нашли дешевле? <br/> Напишите нам, и мы постараемся найти решение.")?>
                                	<?endif?>
                                </p>
                                
                            </div>
                         </form>
                	</td>
                </tr>
                <?if(!empty($additional_images)):?>
                <tr>
                    <td colspan="2">
                        <div class="additional-images">
                            <?foreach ($additional_images as $additional_image):?>
                        	   <a class="product-image" data-lightbox="product-image" href="<?=base_url().'images/data/b/'.$BC->_getCurrentTable().'/'.$additional_image['image']?>"><?=img('images/data/s/'.$BC->_getCurrentTable().'/'.$additional_image['image'])?></a>
                        	<?endforeach?>
                    	</div>
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
                
                <br />
                
                <div id="tabs">
                	<ul>
                		<li><a href="#tabs-1">Regular Comments</a></li>
                		<li><a href="#tabs-2">Facebook Comments</a></li>
                		<li><a href="#tabs-3">VKontakte Comments</a></li>
                	</ul>
                	
                	<div id="tabs-1">
                		<?
		    			    //show comments
		    			    
		    			    $sub_data['post_id'] = $id;
		    			    $sub_data['table'] = $BC->_getCurrentTable();
		    			    
		    			    load_theme_view('inc/comments',$sub_data)
		    			?>
                	</div>
                	<div id="tabs-2">
                		<?load_theme_view('inc/comments-facebook')?>
                	</div>
                	<div id="tabs-3">
                		<?load_theme_view('inc/comments-vkontakte')?>
                	</div>
                </div>
                
            </div>
        </div>
    </div>
</div>


<?=load_inline_js('inc/js-add-to-cart'); ?>


<script>
$j(function() {
	$j( "#tabs" ).tabs();
});
</script>