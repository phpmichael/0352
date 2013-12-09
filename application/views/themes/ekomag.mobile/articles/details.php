<h2><?=$BC->_getPageTitle()?></h2>

<div>           
    <span><?=date('d/m/Y H:i',strtotime($article['pub_date']))?></span>
	
	<div class="article-content"><?=$article['body']?></div>
	
	<?if($article['author']):?>
	<p><?=language('author')?>: <?=$article['author']?></p>
	<?endif?>
	
	<?if($article['source']):?>
	<p><?=language('source')?>: <?=$article['source']?></p>
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
</div>