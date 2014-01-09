<?if(!isset($social_params['button_title'])) $social_params['button_title'] = "Facebook";?>
<?
$btn_size = explode('x',$social_params['button_size']);
$btn_width = $btn_size[0];
$btn_height = $btn_size[1];
?>
<a onclick="window.open('http://www.facebook.com/sharer.php?u=<?=urlencode($social_params['page_url'])?>', 'facebook', 'width=626, height=436'); return false;" href="http://www.facebook.com/sharer.php?u=<?=urlencode($social_params['page_url'])?>" rel="nofollow" title="<?=$social_params['button_title']?>">
    <?=img(array('src'=>'images/social/'.$social_params['button_size'].'/facebook.png','width'=>$btn_width,'height'=>$btn_height))?>
</a>