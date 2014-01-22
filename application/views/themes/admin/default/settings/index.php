<div class="red"><?=validation_errors()?></div>

<form action="" method="post">

<table class="list">
<tr>
	<th colspan="2"><b><?=language('general_settings')?></b></th>
</tr>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("site_title")?> (<?=$lang_code?>): <span class="red">*</span></td>
	<td><?=form_input("site_title_{$lang_code}",set_value("site_title_{$lang_code}",@${'site_title_'.$lang_code}),"class='largeinput'");?></td>
</tr>
<?endforeach?>
<tr>
	<td><?=$BC->_getFieldTitle("send_email_from")?>: <span class="red">*</span></td>
	<td><?=form_input("send_email_from",set_value('send_email_from',@$send_email_from),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("site_email")?>: <span class="red">*</span></td>
	<td><?=form_input("site_email",set_value('site_email',@$site_email),"class='largeinput'");?></td>
</tr>

<tr>
	<th colspan="2"><b><?=language('meta_data')?></b></th>
</tr>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("meta_keywords")?> (<?=$lang_code?>):</td>
	<td><?=form_input("meta_keywords_{$lang_code}",set_value("meta_keywords_{$lang_code}",@${'meta_keywords_'.$lang_code}),"class='largeinput'");?></td>
</tr>
<?endforeach?>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("meta_description")?> (<?=$lang_code?>):</td>
	<td><?=form_input("meta_description_{$lang_code}",set_value("meta_description_{$lang_code}",@${'meta_description_'.$lang_code}),"class='largeinput'");?></td>
</tr>
<?endforeach?>

<tr>
	<th colspan="2"><b><?=language('language')?></b></th>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("default_lang")?>:</td>
	<td><?=form_dropdown("default_lang",get_languages_list(TRUE),set_value('default_lang',@$default_lang));?></td>
</tr>
<?if(userAccess('lang','edit')):?>
<tr>
	<td>Driver for translation:</td>
	<td><?=form_dropdown("translate_driver",array('bing'=>'Bing API','yandex'=>'Yandex API (EN,UK,PL,TR,DE<-->RU)','mymemory'=>'MyMemory API','google'=>'Google Service (Just text)'),set_value('translate_driver',@$translate_driver));?></td>
</tr>
<?endif?>

<?if(userAccess('themes','config')):?>
<tr>
	<th colspan="2"><b><?=language('theme')?></b></th>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("admin_theme")?>:</td>
	<td><?=form_dropdown("admin_theme",$BC->admin_model->getThemesList(TRUE),set_value('admin_theme',@$admin_theme));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("front_theme")?>:</td>
	<td><?=form_dropdown("front_theme",$BC->admin_model->getThemesList(),set_value('front_theme',@$front_theme));?></td>
</tr>
<?endif?>

<?if(userAccess('site_phones','config')):?>
<tr>
	<th colspan="2"><b><?=language('site_phones')?></b></th>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("site_phone1")?>:</td>
	<td><?=form_input("site_phone1",set_value('site_phone1',@$site_phone1));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("site_phone2")?>:</td>
	<td><?=form_input("site_phone2",set_value('site_phone2',@$site_phone2));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("site_phone3")?>:</td>
	<td><?=form_input("site_phone3",set_value('site_phone3',@$site_phone3));?></td>
</tr>
<?endif?>

<?if(userAccess('newsletters','config')):?>
<tr>
	<th colspan="2"><b><?=language('mass_mail')?></b></th>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("newsletters_send_count")?>:</td>
	<td><?=form_input("newsletters_send_count",set_value('newsletters_send_count',@$newsletters_send_count));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("newsletters_send_interval")?>:</td>
	<td><?=form_input("newsletters_send_interval",set_value('newsletters_send_interval',@$newsletters_send_interval));?></td>
</tr>
<?endif?>

<?if(userAccess('products','config')):?>
<tr>
	<th colspan="2"><b><?=language('products_settings')?></b></th>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("use_product_sku")?>:</td>
	<td><?=form_dropdown("use_product_sku",array(0=>language('no'),1=>language('yes')),set_value('use_product_sku',@$use_product_sku));?></td>
</tr>
<?endif?>

<?if(userAccess('poll','config')):?>
<tr>
	<th colspan="2"><b><?=language('poll_settings')?></b></th>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("poll_check_by_cookie")?>:</td>
	<td><?=form_dropdown("poll_check_by_cookie",array(0=>language('no'),1=>language('yes')),set_value('poll_check_by_cookie',@$poll_check_by_cookie));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("poll_check_by_ip")?>:</td>
	<td><?=form_dropdown("poll_check_by_ip",array(0=>language('no'),1=>language('yes')),set_value('poll_check_by_ip',@$poll_check_by_ip));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("poll_check_by_id")?>:</td>
	<td><?=form_dropdown("poll_check_by_id",array(0=>language('no'),1=>language('yes')),set_value('poll_check_by_id',@$poll_check_by_id));?></td>
</tr>
<?endif?>

<?if(userAccess('ratings','config')):?>
<tr>
	<th colspan="2"><b><?=language('ratings_settings')?></b></th>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("ratings_check_by_cookie")?>:</td>
	<td><?=form_dropdown("ratings_check_by_cookie",array(0=>language('no'),1=>language('yes')),set_value('ratings_check_by_cookie',@$ratings_check_by_cookie));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("ratings_check_by_ip")?>:</td>
	<td><?=form_dropdown("ratings_check_by_ip",array(0=>language('no'),1=>language('yes')),set_value('ratings_check_by_ip',@$ratings_check_by_ip));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("ratings_check_by_id")?>:</td>
	<td><?=form_dropdown("ratings_check_by_id",array(0=>language('no'),1=>language('yes')),set_value('ratings_check_by_id',@$ratings_check_by_id));?></td>
</tr>
<?if(userAccess('articles','config')):?>
<tr>
	<td><?=$BC->_getFieldTitle("ratings_for_articles_allowed")?>:</td>
	<td><?=form_dropdown("ratings_for_articles_allowed",array(0=>language('no'),1=>language('yes')),set_value('ratings_for_articles_allowed',@$ratings_for_articles_allowed));?></td>
</tr>
<?endif?>
<?if(userAccess('news','config')):?>
<tr>
	<td><?=$BC->_getFieldTitle("ratings_for_news_allowed")?>:</td>
	<td><?=form_dropdown("ratings_for_news_allowed",array(0=>language('no'),1=>language('yes')),set_value('ratings_for_news_allowed',@$ratings_for_news_allowed));?></td>
</tr>
<?endif?>
<?if(userAccess('comments','config')):?>
<tr>
	<td><?=$BC->_getFieldTitle("ratings_for_comments_allowed")?>:</td>
	<td><?=form_dropdown("ratings_for_comments_allowed",array(0=>language('no'),1=>language('yes')),set_value('ratings_for_comments_allowed',@$ratings_for_comments_allowed));?></td>
</tr>
<?endif?>
<?if(userAccess('products','config')):?>
<tr>
	<td><?=$BC->_getFieldTitle("ratings_for_products_allowed")?>:</td>
	<td><?=form_dropdown("ratings_for_products_allowed",array(0=>language('no'),1=>language('yes')),set_value('ratings_for_products_allowed',@$ratings_for_products_allowed));?></td>
</tr>
<?endif?>
<?if(userAccess('photos','config')):?>
<tr>
	<td><?=$BC->_getFieldTitle("ratings_for_photos_allowed")?>:</td>
	<td><?=form_dropdown("ratings_for_photos_allowed",array(0=>language('no'),1=>language('yes')),set_value('ratings_for_photos_allowed',@$ratings_for_photos_allowed));?></td>
</tr>
<?endif?>
<?if(userAccess('companies','config')):?>
<tr>
	<td><?=$BC->_getFieldTitle("ratings_for_companies_allowed")?>:</td>
	<td><?=form_dropdown("ratings_for_companies_allowed",array(0=>language('no'),1=>language('yes')),set_value('ratings_for_companies_allowed',@$ratings_for_companies_allowed));?></td>
</tr>
<?endif?>
<?endif?>

<?if(userAccess('comments','config')):?>
<tr>
	<th colspan="2"><b><?=language('comments_settings')?></b></th>
</tr>
<?if(userAccess('articles','config')):?>
<tr>
	<td><?=$BC->_getFieldTitle("comments_for_articles_allowed")?>:</td>
	<td><?=form_dropdown("comments_for_articles_allowed",array(0=>language('no'),1=>language('yes')),set_value('comments_for_articles_allowed',@$comments_for_articles_allowed));?></td>
</tr>
<?endif?>
<?if(userAccess('news','config')):?>
<tr>
	<td><?=$BC->_getFieldTitle("comments_for_news_allowed")?>:</td>
	<td><?=form_dropdown("comments_for_news_allowed",array(0=>language('no'),1=>language('yes')),set_value('comments_for_news_allowed',@$comments_for_news_allowed));?></td>
</tr>
<?endif?>
<?if(userAccess('products','config')):?>
<tr>
	<td><?=$BC->_getFieldTitle("comments_for_products_allowed")?>:</td>
	<td><?=form_dropdown("comments_for_products_allowed",array(0=>language('no'),1=>language('yes')),set_value('comments_for_products_allowed',@$comments_for_products_allowed));?></td>
</tr>
<?endif?>
<tr>
	<td><?=$BC->_getFieldTitle("automatic_approve_comments")?>:</td>
	<td><?=form_dropdown("automatic_approve_comments",array(0=>language('no'),1=>language('yes')),set_value('automatic_approve_comments',@$automatic_approve_comments));?></td>
</tr>
<tr>
	<td style="vertical-align:top"><?=$BC->_getFieldTitle("comments_censor_list")?></td>
	<td><?=form_textarea('comments_censor_list',@$comments_censor_list)?></td>
</tr>
<tr>
	<td style="vertical-align:top"><?=$BC->_getFieldTitle("ip_blacklist")?></td>
	<td><?=form_textarea('ip_blacklist',@$ip_blacklist)?></td>
</tr>
<?endif?>

<?if(userAccess('photos','config')):?>
<tr>
	<th colspan="2"><b><?=language('gallery_settings')?></b></th>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("gallery_per_page")?>:</td>
	<td><?=form_input("gallery_per_page",set_value('gallery_per_page',@$gallery_per_page));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("gallery_table_cols")?>:</td>
	<td><?=form_input("gallery_table_cols",set_value('gallery_table_cols',@$gallery_table_cols));?></td>
</tr>

<tr>
	<th colspan="2"><b><?=language('photos_settings')?></b></th>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("photos_big_dir")?>:</td>
	<td><?=form_input("photos_big_dir",set_value('photos_big_dir',@$photos_big_dir));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("photos_small_dir")?>:</td>
	<td><?=form_input("photos_small_dir",set_value('photos_small_dir',@$photos_small_dir));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("photos_big_width")?>:</td>
	<td><?=form_input("photos_big_width",set_value('photos_big_width',@$photos_big_width));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("photos_big_height")?>:</td>
	<td><?=form_input("photos_big_height",set_value('photos_big_height',@$photos_big_height));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("photos_big_crop")?>:</td>
	<td><?=form_dropdown("photos_big_crop",array(0=>language('no'),1=>language('yes')),set_value('photos_big_crop',@$photos_big_crop));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("photos_small_width")?>:</td>
	<td><?=form_input("photos_small_width",set_value('photos_small_width',@$photos_small_width));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("photos_small_height")?>:</td>
	<td><?=form_input("photos_small_height",set_value('photos_small_height',@$photos_small_height));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("photos_small_crop")?>:</td>
	<td><?=form_dropdown("photos_small_crop",array(0=>language('no'),1=>language('yes')),set_value('photos_small_crop',@$photos_small_crop));?></td>
</tr>
<?endif?>

<?if(userAccess('site_partners','config')):?>
<tr>
	<th colspan="2"><b><?=language('partners')?> (HTML code)</b></th>
</tr>
<tr>
	<td style="vertical-align:top"><?=$BC->_getFieldTitle("site_partners")?></td>
	<td><?=form_textarea('site_partners',@$site_partners)?></td>
</tr>
<?endif?>

</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>

<script>

$j(document).ready(function(){
    /*$j("table.list tr td").parent().hide();
    
    $j("table.list tr th").click(function(){
        $j(this).parent().nextAll("tr").toggle();
    });*/
});

</script>