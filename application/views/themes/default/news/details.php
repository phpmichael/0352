<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<span><?=$news['pub_date']?></span>

<div><?=$news['body']?></div>

<?load_theme_view('inc/box-rate',array('post_id'=>$news['id'],'rating'=>$news['rating'],'already_rated'=>$news['already_rated'],'table'=>$BC->_getCurrentTable()));?>

<?load_theme_view('inc/box-post-tags',array('post_id'=>$news['id']));?>

<?if(isset($news['post_categories'])):?>
<?load_theme_view('inc/box-post-categories',array('post_categories'=>$news['post_categories'],'method'=>'index'));?>
<?endif?>

<?
    //show comments
    
    $sub_data['post_id'] = $news['id'];
    $sub_data['table'] = $BC->_getCurrentTable();
    $sub_data['comments_opened'] = $news['comments_opened'];
    
    load_theme_view('inc/comments',$sub_data)
?>