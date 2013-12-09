<div class="section">                   
                        
   <h1 class="title" id="page-title"><?=$BC->_getPageTitle()?></h1>
                        
   <div id="block-system-main">
      
        <div class="node">
        
          <div class="content">
                
        		<div><?=nl2br($video['description'])?></div>
		
        		<p><?social_buttons()?></p>
        		
        		<div>
	        		<?=show_embed_video($video);?>
        		</div>
            
          </div><!-- /.content -->
      
        </div><!-- /.node -->  

    </div><!-- /.block -->  
    
</div>