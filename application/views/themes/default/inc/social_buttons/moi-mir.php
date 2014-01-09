<?if(!isset($social_params['button_title'])) $social_params['button_title'] = "Мой мир на mail.ru";?>
<?
$btn_size = explode('x',$social_params['button_size']);
$btn_width = $btn_size[0];
$btn_height = $btn_size[1];
?>
<a onclick="window.open('http://connect.mail.ru/share?share_url=<?=urlencode($social_params['page_url'])?>', 'moimir', 'width=626, height=436'); return false;" href="http://connect.mail.ru/share?share_url=<?=urlencode($social_params['page_url'])?>" rel="nofollow" title="<?=$social_params['button_title']?>">
    <?=img(array('src'=>'images/social/'.$social_params['button_size'].'/moi-mir.png','width'=>$btn_width,'height'=>$btn_height))?>
</a>