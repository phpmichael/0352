<div class="section">

    <h1 class="title" id="page-title"><?=$BC->_getPageTitle()?></h1>

    <div>
        
        <?if( $posts_list ):?>
        
        	<div class="toolbar-top">
    	        <?//load_theme_view('inc/tpl-products-toolbar');?>
    	    </div>
    	    
    	    <br class="clear" />
        
    	    <div class="section-4 clearfix">
            	<div class="region region-header-bottom">
            		<div id="block-views-services-block" class="block block-views block-even">
            			<div class="content">
            				<div class="view view-services view-id-services view-display-id-block view-dom-id-3">
            					<div class="view-content">
            					    <?//$posts_list = array_merge($posts_list,$posts_list,$posts_list)?>
            						<?$i=0; foreach ($posts_list as $assortment): $i++; ?>
            						<div class="views-row views-row-<?=$i?>">
            							<div class="views-field views-field-body">
            							
            								<div style="position:relative;">
            									<img src="<?=base_url()?>images/data/m/assortment/<?=$assortment->img?>" width="210" height="160" alt="<?=htmlspecialchars($assortment->name)?>" />
            									<div class="image-overlay"><div><span><?=$assortment->name?></span></div></div>
            								</div>
            								
            								<?if($assortment->main_category=='1'):?>
            								<table class="tile-prices-box">
                							<tbody>
                							     <tr>
                							         <td><?=$assortment->type1?></td>
                							         <td><?if($assortment->type1):?>від <?=$assortment->price1?> грн./м<sup>2</sup><?else:?>&nbsp;<?endif?></td>
                							     </tr>
                							     <tr>
                							         <td><?=$assortment->type2?></td>
                							         <td><?if($assortment->type2):?>від <?=$assortment->price2?> грн./м<sup>2</sup><?else:?>&nbsp;<?endif?></td>
                							     </tr>
                							     <tr>
                							         <td><?=$assortment->type3?></td>
                							         <td><?if($assortment->type3):?>від <?=$assortment->price3?> грн./м<sup>2</sup><?else:?>&nbsp;<?endif?></td>
                							     </tr>
                							</tbody>
                							</table>
                							<?endif?>
            							</div>
            
            							<div class="views-field-view-node">
            								<span><a href="<?=site_url('assortment/name/'.$assortment->slug)?>">Детальніше</a></span>
            							</div>
            						</div>
            						<?endforeach?>
            						
            					</div>
            				</div>
            			</div><!-- /.content -->
            		</div><!-- /.block -->
            	</div>
            </div><!-- /.section -->
            <!-- /.section -->
            
            <div class="pagination"><?=$paginate?></div>
            
            <br class="clear" />
            
            <div class="toolbar-bottom">
    	        <?//load_theme_view('inc/tpl-products-toolbar');?>
    	    </div>
        
        <?else:?>
            <h2><?=language('search_did_not_give_any_results')?></h2>
        <?endif?>
    </div>
</div>

<script>
//<![CDATA[
$j(document).ready(function(){
    $j(".form-products-toolbar select").change(function(){
        $j(this).parents('form').submit();
    });
    
    $j(".sort-direction").click(function(){
    	$j(".form-products-toolbar input[name=sort_order]").val($j(".sort-direction").attr('rel'));
        $j(this).parents('form').submit();
    });
});
//]]>
</script>