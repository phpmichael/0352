<?if(!isset($social_params['button_title'])) $social_params['button_title'] = "ВКонтакте";?>
<?
$btn_size = explode('x',$social_params['button_size']);
$btn_width = $btn_size[0];
$btn_height = $btn_size[1];
?>
<a onclick="window.open('http://vkontakte.ru/share.php?url=<?=urlencode($social_params['page_url'])?>', 'vkontakte', 'width=626, height=436'); return false;" href="http://vkontakte.ru/share.php?url=<?=urlencode($social_params['page_url'])?>" rel="nofollow" title="<?=$social_params['button_title']?>">
    <?=img(array('src'=>'images/social/'.$social_params['button_size'].'/vkontakte.png','width'=>$btn_width,'height'=>$btn_height))?>
</a>