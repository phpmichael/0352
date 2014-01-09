<?if(!isset($social_params['button_title'])) $social_params['button_title'] = "Одноклассники";?>
<?
$btn_size = explode('x',$social_params['button_size']);
$btn_width = $btn_size[0];
$btn_height = $btn_size[1];
?>
<a onclick="window.open('http://www.odnoklassniki.ru/dk?st.cmd=addShare&amp;st.s=1&amp;st._surl=<?=urlencode($social_params['page_url'])?>', 'odnoklassniki', 'width=626, height=436'); return false;" href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&amp;st.s=1&amp;st._surl=<?=urlencode($social_params['page_url'])?>" rel="nofollow" title="<?=$social_params['button_title']?>">
    <?=img(array('src'=>'images/social/'.$social_params['button_size'].'/odnoklassniki.png','width'=>$btn_width,'height'=>$btn_height))?>
</a>