<div id="page">
    <h2 class="title"><span><span><?=$BC->_getPageTitle()?></span></span></h2>

    <div class="boxIndent">
        <div class="wrapper">
            <div class="content">
                <br />
                <!-- Boxes Start -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                	<tr>
                		<?$i=0; foreach ($categories as $item): $i++?>
                		
                		    <?if($i!=1 && $i%2):?></tr><tr><?endif?>
                		
            		        <td width="50%" class="grid-box">
                                    
        		                <div class="featuredIndent">
        		                    
        		                    <div class="category_image_container">
        		                        <a title="<?=htmlspecialchars($item['category'])?>" href="<?=site_url($BC->_getBaseURL()."{$controller}/index/category/".$item['id'])?>" class="product-image" data-lightbox="product-image">
                                        	<?if(@$item['file_name']) echo img('images/data/s/products_categories_list/'.$item['file_name'])?>
                                        </a>
        		                    </div>
        		
        		                    <div class="category_name">
        		                      <?=anchor_base("{$controller}/index/category/".$item['id'],$item['category'])?>    
        		                    </div>
        		                </div>
            		            
            	            </td>
                		
                		<?endforeach;?>
                		
                		<?while($i%2):$i++?><td width="50%" class="grid-box"></td><?endwhile?>
                	</tr>
                </tbody>
                </table>
                <!-- Boxes End -->
            </div>
        </div>
    </div>
</div>
