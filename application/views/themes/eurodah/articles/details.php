<div class="section">                   
                        
   <h1 class="title" id="page-title"><?=$BC->_getPageTitle()?></h1>
                        
   <div id="block-system-main">
      
        <div class="node">
        
          <div class="content">
                
                <span class="submitted"><?=date('d/m/Y H:i',strtotime($article['pub_date']))?></span>
		
        		<div class="article-content"><?=$article['body']?></div>
        		
        		<?if($article['author']):?>
        		<p><strong><?=language('author')?>:</strong> <?=$article['author']?></p>
        		<?endif?>
        		
        		<?if($article['source']):?>
        		<p><strong><?=language('source')?>:</strong> <?=$article['source']?></p>
        		<?endif?>
        		
        		<?load_theme_view('inc/box-rate',array('post_id'=>$article['id'],'rating'=>$article['rating'],'already_rated'=>$article['already_rated'],'table'=>$BC->_getCurrentTable()));?>
        		
        		<p><?social_buttons()?></p>
        		
        		<?load_theme_view('inc/box-post-tags',array('post_id'=>$article['id']));?>
        		
        		<?
        		    //show comments
        		    
        		    $sub_data['post_id'] = $article['id'];
        		    $sub_data['table'] = $BC->_getCurrentTable();
        		    $sub_data['comments_opened'] = $article['comments_opened'];
        		    
        		    load_theme_view('inc/comments',$sub_data)
        		?> 
            
          </div><!-- /.content -->
      
        </div><!-- /.node -->  

    </div><!-- /.block -->  
    
</div>