<div class="section">                   
                        
   <h1 class="title" id="page-title"><?=$BC->_getPageTitle()?></h1>
                        
   <div id="block-system-main">
      
        <div class="node">
        
          <div class="content">
                
        		<?if(!empty($videos_records)):?>
		
                <?foreach ($videos_records as $record):?>
                <p>
                	<?=anchor($BC->_getBaseURI().'/view/'.$record['data_key'],$record['title'])?>
                </p>
                <p>
                	<?=nl2br($record['description'])?>
                </p>
                <?endforeach;?>
                
                <div class="pagination"><?php echo $paginate; ?></div>
                
                <?endif;?>
            
          </div><!-- /.content -->
      
        </div><!-- /.node -->  

    </div><!-- /.block -->  
    
</div>