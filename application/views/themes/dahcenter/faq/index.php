<div class="section">                   
                        
   <h1 class="title" id="page-title"><?=$BC->_getPageTitle()?></h1>
                        
   <div id="block-system-main">
      
        <div class="node">
        
          <div class="content">
          
            <div class="faq">
                
                <?if(!empty($faq_records)):?>

                    <?foreach ($faq_records as $record):?>
                    
                        <div class="question">
                            <span class="q">Запитання: &nbsp; </span>
                            <h5><?=$record['question']?></h5>
                        </div>
                        <div class="answer">
                            <span class="a">Відповідь:  &nbsp;  </span>
                            <div class="answer_det"><?=nl2br($record['answer'])?></div>
                        </div>
                        
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