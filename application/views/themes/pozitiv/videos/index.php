<div>                   
                        
   <?if(!empty($videos_records)):?>
		
    <?foreach ($videos_records as $record):?>
    <div style="float:left;width:400px;">
    	<p>
    		<b><?=anchor($BC->_getBaseURI().'/view/'.$record['data_key'],$record['title'])?></b>
    	</p>
    	<p>
    		<?$record['url'] .= "[370|210]"?>
    		<?=show_embed_video($record);?>
    	</p>
    </div>
    <?endforeach;?>
    
    <div style="clear:both"></div>
    
    <div class="pagination"><?php echo $paginate; ?></div>
    
    <?endif;?>
    
</div>