<div id="page">
    <h2 class="title"><span><span><?=$BC->_getPageTitle()?></span></span></h2>

    <div class="boxIndent">
        <div class="wrapper">
            <div class="content">
            
                <span><?=date('d/m/Y H:i',strtotime($article['pub_date']))?></span>
    			
    			<div><?=$article['body']?></div>
    			
    			<?//load_theme_view('inc/box-rate',array('post_id'=>$article['id'],'rating'=>$article['rating'],'already_rated'=>$article['already_rated'],'table'=>$BC->_getCurrentTable()));?>
    			
    			<?load_theme_view('inc/box-post-tags',array('post_id'=>$article['id']));?>
    			
    			<?load_theme_view('inc/box-social-buttons')?>
    			
    			<div id="tabs">
                	<ul>
                		<li><a href="#tabs-1">Comment</a></li>
                		<li><a href="#tabs-2">Facebook </a></li>
                	</ul>
                	
                	<div id="tabs-1">
                		<?
		    			    //show comments
		    			    
		    			    $sub_data['post_id'] = $article['id'];
		    			    $sub_data['table'] = $BC->_getCurrentTable();
		    			    $sub_data['comments_opened'] = $article['comments_opened'];
		    			    
		    			    load_theme_view('inc/comments',$sub_data)
		    			?>
                	</div>
                	<div id="tabs-2">
                		<?load_theme_view('inc/comments-facebook')?>
                	</div>
                </div>
				
            </div>
        </div>
    </div>
</div>


<script>
$j(function() {
	$j( "#tabs" ).tabs();
});
</script>