<h1><?=$BC->_getPageTitle()?></h1>

<p><?=date('d/m/Y H:i',strtotime($article['pub_date']))?></p>

<div class="well">
	<?=$article['body']?>
</div>

<?load_theme_view('inc/box-rate',array('post_id'=>$article['id'],'rating'=>$article['rating'],'already_rated'=>$article['already_rated'],'table'=>$BC->_getCurrentTable()));?>
	
<?load_theme_view('inc/box-post-tags',array('post_id'=>$article['id']));?>

<p><?=social_buttons();?></p>

<div>
	<?
	    //show comments
	    
	    $sub_data['post_id'] = $article['id'];
	    $sub_data['table'] = $BC->_getCurrentTable();
	    $sub_data['comments_opened'] = $article['comments_opened'];
	    
	    load_theme_view('inc/comments',$sub_data)
	?>
</div>