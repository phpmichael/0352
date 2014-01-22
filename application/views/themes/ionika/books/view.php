<div id="page">
    <h2 class="title"><span><span><?=$BC->_getPageTitle()?></span></span></h2>

    <div class="boxIndent">
        <div class="wrapper">
            <div class="content">
                <table>
                <tr>
                    <td width="50%">
                        <div class="product_image_container">
                            <?if(@$photo1):?>
                        	<a href="<?=base_url().'images/data/b/books/'.$photo1?>" class="product-image">
                        		<?=img(array('src'=>'images/data/m/books/'.$photo1))?>
                        	</a>
                        	<?endif?>
                        </div>
                    </td>
                    <td width="50%">
                		<form action="<?=relative_url($BC->_getBaseURL()."/cart/add")?>" class="add-product">
                            <?=form_hidden('id',$data_key)?>
    
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
	                                
	                                <!-- Manudacturer -->
                                    <?if($manufacturer):?>
                                        <p><strong><?=language('manufacturer')?>: <?=anchor_base('books/search/manufacturer/'.urlencode($manufacturer),$manufacturer)?></strong></p>
                                    <?endif?>
                                
                                <?else:?>
                                
                                	<p><?=language('not_in_stock')?></p>
                                
                                <?endif?>
                                
                                <?load_theme_view('inc/box-social-buttons')?>
                                
                            </div>
                         </form>
                	</td>
                </tr>
                
                <tr>
                    <td colspan="2">
                        <div class="additional-images"> 
                        	<?if(@$photo2):?>
                        	<a href="<?=base_url().'images/data/b/books/'.$photo2?>" class="product-image">
                        		<?=img(array('src'=>'images/data/s/books/'.$photo2))?>
                        	</a>
                        	<?endif?>
                        	
                        	<?if(@$photo3):?>
                        	<a href="<?=base_url().'images/data/b/books/'.$photo3?>" class="product-image">
                        		<?=img(array('src'=>'images/data/s/books/'.$photo3))?>
                        	</a>
                        	<?endif?>
                        	
                        	<?if(@$photo4):?>
                        	<a href="<?=base_url().'images/data/b/books/'.$photo4?>" class="product-image">
                        		<?=img(array('src'=>'images/data/s/books/'.$photo4))?>
                        	</a>
                        	<?endif?>
                        	
                        	<?if(@$photo5):?>
                        	<a href="<?=base_url().'images/data/b/books/'.$photo5?>" class="product-image">
                        		<?=img(array('src'=>'images/data/s/books/'.$photo5))?>
                        	</a>
                        	<?endif?>
                    	</div>
                    </td>
                </tr>
                
                </table>
                
                <?if(@($description)):?>
                    <?=$description?>
                <?endif?>
                
                <?load_theme_view('inc/box-rate',array('post_id'=>$data_key,'rating'=>$rating,'already_rated'=>$already_rated,'table'=>$BC->_getCurrentTable()));?>
                
                <?load_theme_view('inc/box-post-tags',array('post_id'=>$data_key));?>
                
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
		    			    
		    			    $sub_data['post_id'] = $data_key;
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


<?$this->load->view('inc/js-add-to-cart'); ?>      


<script>

$j(function() {
	$j( "#tabs" ).tabs();
});

</script>