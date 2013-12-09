<div class="main-block">
    <div class="top-corners"><div><div>&nbsp;</div></div></div>

    <div class="corner">
        <div class="full-width">
            <div class="article">
                <div class="page-title">
                    <h1><?=$BC->_getPageTitle()?></h1>
                </div>
    
    			<span><?=date('d/m/Y H:i',strtotime($article['pub_date']))?></span>
    			
    			<div class="content"><?=$article['body']?></div>
    			
    			<?load_theme_view('inc/box-rate',array('post_id'=>$article['id'],'rating'=>$article['rating'],'already_rated'=>$article['already_rated'],'table'=>$BC->_getCurrentTable()));?>
    			
    			<?load_theme_view('inc/box-post-tags',array('post_id'=>$article['id']));?>
    			
    			<?
    			    //show comments
    			    
    			    $sub_data['post_id'] = $article['id'];
    			    $sub_data['table'] = $BC->_getCurrentTable();
    			    $sub_data['comments_opened'] = $article['comments_opened'];
    			    
    			    load_theme_view('inc/comments',$sub_data)
    			?>
    			
    		</div>
		</div>
    </div>

    <div class="bot-corners"><div><div>&nbsp;</div></div></div>
</div>