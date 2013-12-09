<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<span><?=$article['pub_date']?></span>

<div><?=$article['body']?></div>

<?load_theme_view('inc/box-rate',array('post_id'=>$article['id'],'rating'=>$article['rating'],'already_rated'=>$article['already_rated'],'table'=>$BC->_getCurrentTable()));?>

<?load_theme_view('inc/box-post-tags',array('post_id'=>$article['id']));?>

<?if(isset($article['post_categories'])):?>
<?load_theme_view('inc/box-post-categories',array('post_categories'=>$article['post_categories'],'method'=>'index'));?>
<?endif?>

<?
    //show comments
    
    $sub_data['post_id'] = $article['id'];
    $sub_data['table'] = $BC->_getCurrentTable();
    $sub_data['comments_opened'] = $article['comments_opened'];
    
    load_theme_view('inc/comments',$sub_data)
?>