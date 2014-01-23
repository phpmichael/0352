<div class="section">                   
                        
   <h1 class="title" id="page-title"><?=$BC->_getPageTitle()?></h1>
                        
   <div id="block-system-main">
      
        <div class="node">
        
          <div class="content">
                
        		<div>
        		
        		    <div class="views-row views-row-1">
						<div class="views-field views-field-body">
						
							<div style="position:relative;float:left">
								<a href="<?=base_url()?>images/data/b/assortment/<?=$img?>" class="lightbox"><img src="<?=base_url()?>images/data/m/assortment/<?=$img?>" alt="<?=htmlspecialchars($name)?>" /></a>
								<p><?social_buttons()?></p>
							</div>
							
							<?if($main_category=='1'):?>
							<div style="float:left;margin:0 0 0 20px;">
							
    							<table width="100%">
    							<tbody>
    							     <tr>
    							         <td><?=$type1?></td>
    							         <td><?if($type1):?>від <?=$price1?> грн./м<sup>2</sup><?else:?>&nbsp;<?endif?></td>
    							     </tr>
    							     <tr>
    							         <td><?=$type2?></td>
    							         <td><?if($type2):?>від <?=$price2?> грн./м<sup>2</sup><?else:?>&nbsp;<?endif?></td>
    							     </tr>
    							     <tr>
    							         <td><?=$type3?></td>
    							         <td><?if($type3):?>від <?=$price3?> грн./м<sup>2</sup><?else:?>&nbsp;<?endif?></td>
    							     </tr>
    							</tbody>
    							</table>
    							
							</div>
							<?endif?>
							<div style="clear:both;"></div>
						</div>
					</div>
        		
					<?if($description || $characteristics || $assortment || $accessories ):?>
            		<div id="tabs">
                    	<ul>
                    		<?if($description):?><li><a href="#tabs-1">Опис</a></li><?endif?>
                    		<?if($characteristics):?><li><a href="#tabs-2">Характеристики</a></li><?endif?>
                    		<?if($assortment):?><li><a href="#tabs-3">Асортимент</a></li><?endif?>
                    		<?if($accessories):?><li><a href="#tabs-4">Аксесуари</a></li><?endif?>
                    	</ul>
                    	<?if($description):?>
                    	<div id="tabs-1">
                    		<?=$description?>
                    	</div>
                    	<?endif?>
                    	<?if($characteristics):?>
                    	<div id="tabs-2">
                    		<?=$characteristics?>
                    	</div>
                    	<?endif?>
                    	<?if($assortment):?>
                    	<div id="tabs-3">
                    		<?=$assortment?>
                    	</div>
                    	<?endif?>
                    	<?if($accessories):?>
                    	<div id="tabs-4">
                    		<?=$accessories?>
                    	</div>
                    	<?endif?>
                    </div>
                    <?endif?>
        		
        		</div>
            
          </div><!-- /.content -->
      
        </div><!-- /.node -->  

    </div><!-- /.block -->  
    
</div>

<script>
$j(function() {
	$j( "#tabs" ).tabs();
});
</script>