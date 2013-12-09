<div>                   
                        
   	<h1><?=nl2br($video['title'])?></h1>
   	
   	<p><?=nl2br($video['description'])?></p>
	
	<p>
		<?$video['url'] .= "[800|500]"?>
		<?=show_embed_video($video);?>
	</p> 
    
</div>