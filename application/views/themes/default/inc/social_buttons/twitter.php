<?if(!isset($social_params['button_title'])) $social_params['button_title'] = "Twitter";?>
<?
$btn_size = explode('x',$social_params['button_size']);
$btn_width = $btn_size[0];
$btn_height = $btn_size[1];
?>
<a onclick="window.open('http://twitter.com/home?status=<?=urlencode($social_params['page_url'])?>', 'twitter', 'width=626, height=436'); return false;" href="http://twitter.com/home?status=<?=urlencode($social_params['page_url'])?>" rel="nofollow" title="<?=$social_params['button_title']?>">
    <?=img(array('src'=>'images/social/'.$social_params['button_size'].'/twitter.png','width'=>$btn_width,'height'=>$btn_height))?>
</a>