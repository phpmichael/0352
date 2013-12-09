<div class="section">                   
                        
   <h1 class="title" id="page-title"><?=$BC->_getPageTitle()?></h1>
                        
   <div id="block-system-main">
      
        <div class="node">
        
          <div class="content">
          
            <div class="faq">
                
                <?if(!empty($testimonials_records)):?>

                    <?foreach ($testimonials_records as $record):?>
                        <h5><?=$record['name']?>:</h5>
                        
                        <blockquote>
                            <?=nl2br($record['content'])?>
                        </blockquote>
                        
                    <?endforeach;?>
                    
                    <?if($paginate):?>
                        <div class="pagination">
                            <p><?=language('page')?>: </p><?=$paginate?>
                        </div>
                    <?endif?>
                
                <?endif;?>
                
            </div>  
            
          </div><!-- /.content -->
      
        </div><!-- /.node -->  

    </div><!-- /.block -->  
    
</div>