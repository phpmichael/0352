<h1><?=$BC->_getPageTitle()?></h1>

<div class="well">
    <table>
    <tr>
        <td width="50%">
            <?if(@$image):?>
        	<a href="<?=base_url().'images/data/b/products/'.$image?>" class="product-image" data-lightbox="product-image">
        		<?=img(array('src'=>'images/data/m/products/'.$image))?>
        	</a>
        	<?endif?>
        </td>
        <td width="50%">
    		<form action="<?=relative_url($BC->_getBaseURL()."/cart/add")?>" class="add-product">
                <?=form_hidden('id',$id)?>

                <div>
                    
                    <div><?=language('price')?>: <span class="badge badge-important product-price"><?=exchange($price)?></span></div>
                    
                    <?if($old_price!=0.00):?>
                       <div><?=language('old_price')?>: <span class="badge badge-default product-price"><?=exchange($old_price)?></span></div>
                    <?endif?>
                    
                    <?if($in_stock):?>
                    
                        <?=form_input('qty',1,"size='1' class='input-mini' style='margin:0;'")?>
                    
                        <?=form_submit('',language('add_to_cart'),"class='btn btn-primary'")?>
                        
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
                    
                    <p><?social_buttons()?></p>
                    
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
    
    <?load_theme_view('inc/box-rate',array('post_id'=>$id,'rating'=>$rating,'already_rated'=>$already_rated,'table'=>$BC->_getCurrentTable()));?>
    
    <?load_theme_view('inc/box-post-tags',array('post_id'=>$id));?>
    
    <div>
    	<?
		    //show comments
		    
		    $sub_data['post_id'] = $id;
		    $sub_data['table'] = $BC->_getCurrentTable();
		    
		    load_theme_view('inc/comments',$sub_data)
		?>
    </div>
    
</div>


<?=load_inline_js('inc/js-add-to-cart'); ?>