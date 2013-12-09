
    <h2><?=$BC->_getPageTitle()?></h2>

    <div class="boxIndent">
        <!-- Boxes Start -->
        <div id="products-categories-list">
                
            <table width="100%">
               <tbody>
               	   <tr>
               	   
               	   <?$i=0; foreach ($categories as $item): $i++?>
               
                   <?if($i!=1 && ($i%2)):?></tr><tr><?endif?>
                   
                       <td class="vt" width="50%" align="center">
							<br />
                       		<?=anchor_base("{$controller}/index/category/".$item['id'],$item['category'],"class='category-name'")?>
                          	<br />
                          	<br />
                       
                          	<div align="center">
                                <a title="<?=htmlspecialchars($item['category'])?>" href="<?=site_url($BC->_getBaseURL()."{$controller}/index/category/".$item['id'])?>" class="product-image">
                                	<?if(@$item['file_name']) echo img(array('src'=>'images/data/s/products_categories_list/'.$item['file_name'],'alt'=>htmlspecialchars($item['alt']),'width'=>$BC->settings_model['products_categories_list_small_width'],'height'=>$BC->settings_model['products_categories_list_small_height']))?>
                                </a>
                            </div>
                            
                            <br />
                          	<?=nl2br($item['description'])?> 
							<br />
                       </td>
                   
                   <?endforeach;?>
    	
    			   <?while($i%2):$i++?><td width="50%" class="vt" align="center"></td><?endwhile?>
    			   
                   </tr>
               </tbody>
            </table>
        	
        </div>
        <!-- Boxes End -->
    </div>