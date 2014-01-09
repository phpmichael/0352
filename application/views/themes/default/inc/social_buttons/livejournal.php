<?if(!isset($social_params['button_title'])) $social_params['button_title'] = "LiveJournal";?>
<?
$btn_size = explode('x',$social_params['button_size']);
$btn_width = $btn_size[0];
$btn_height = $btn_size[1];
?>
<a onclick="window.open('http://www.livejournal.com/update.bml?event=<?=urlencode($social_params['page_url'])?>&amp;subject=<?=urlencode($head['page_title'])?>', 'livejournal', 'width=626, height=436'); return false;" href="http://www.livejournal.com/update.bml?event=<?=urlencode($social_params['page_url'])?>&amp;subject=<?=urlencode($head['page_title'])?>" rel="nofollow" title="<?=$social_params['button_title']?>">
    <?=img(array('src'=>'images/social/'.$social_params['button_size'].'/livejournal.png','width'=>$btn_width,'height'=>$btn_height))?>
</a>