<?
$BC->load->helper('customer');
$BC->load->helper('blog');
$BC->load->helper('poll');
$BC->load->helper('social');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?load_theme_view('inc/tpl-head')?>
</head>

<body>

<div id="wrapper">
    <div id="dialog"></div>
    
	<div id="header">
	
            <div id="logo" onclick="location.href='<?=base_url().$BC->_getBaseURL()?>'"></div>
            
            <div class="lang-select">
            	<a href="<?=base_url()?>" title="<?=language('ukrainian')?>" class="flag flag-ua"></a> 
                <a href="<?=base_url().'ru/'?>" title="<?=language('russian')?>" class="flag flag-ru"></a>
                
                <a href="<?=site_url('articles/RSS')?>" title="RSS <?=language('articles')?>" class="rss-icon"></a>
            </div>
            
            <div id="main-menu">
                <?if($BC->_getInterfaceLang()=='ru'):?>
                    <?=anchor_base('products/index/category/1','все для дома','id="menu-item1"'.( (preg_match('[/products/index/category/1\b]',$current_location_str))?' class="active" ':"" ))?>
                    <?=anchor_base('products/index/category/2','средства гигиены','id="menu-item2"'.( (preg_match('[/products/index/category/2\b]',$current_location_str))?' class="active" ':"" ))?>
                    <?=anchor_base('products/index/category/3','аромо терапия','id="menu-item3"'.( (preg_match('[/products/index/category/3\b]',$current_location_str))?' class="active" ':"" ))?>
                    <?=anchor_base('products/index/category/4','косме тика','id="menu-item4"'.( (preg_match('[/products/index/category/4\b]',$current_location_str))?' class="active" ':"" ))?>
                    <?=anchor_base('articles','видео статьи','id="menu-item5"'.( (preg_match('[/articles\b]',$current_location_str))?' class="active" ':"" ))?>
                    <?=anchor_base('faq','вопросы ответы','id="menu-item6"'.( (preg_match('[/faq\b]',$current_location_str))?' class="active" ':"" ))?>
                    <?=anchor('ru/page/kak-kupit','как купить','id="menu-item7"'.( (preg_match('[/kak-kupit\b]',$current_location_str))?' class="active" ':"" ))?>
                <?else:?>
                    <?=anchor_base('products/index/category/1','все для дому','id="menu-item1"'.( (preg_match('[/products/index/category/1\b]',$current_location_str))?' class="active" ':"" ))?>
                    <?=anchor_base('products/index/category/2','засоби гігієни','id="menu-item2"'.( (preg_match('[/products/index/category/2\b]',$current_location_str))?' class="active" ':"" ))?>
                    <?=anchor_base('products/index/category/3','аромо терапія','id="menu-item3"'.( (preg_match('[/products/index/category/3\b]',$current_location_str))?' class="active" ':"" ))?>
                    <?=anchor_base('products/index/category/4','косме тика','id="menu-item4"'.( (preg_match('[/products/index/category/4\b]',$current_location_str))?' class="active" ':"" ))?>
                    <?=anchor_base('articles','відео статті','id="menu-item5"'.( (preg_match('[/articles\b]',$current_location_str))?' class="active" ':"" ))?>
                    <?=anchor_base('faq','питання відповіді','id="menu-item6"'.( (preg_match('[/faq\b]',$current_location_str))?' class="active" ':"" ))?>
                    <?=anchor('page/yak-kupiti','як купити','id="menu-item7"'.( (preg_match('[/yak-kupiti\b]',$current_location_str))?' class="active" ':"" ))?>
                <?endif?>
            </div>
	    
	</div>
	
	<div id="body">
	
	    <div class="bread-crumb">                
            <?if(!$BC->is_home_page()):?>
                <?load_theme_view('inc/tpl-cur-location.php')?>
            <?endif?>
        </div>
        
        <div id="left-sidebar" class="sidebar">
		
			<?load_theme_view('inc/left-sidebar')?>
					
		</div>
	    
		<div id="content">
		
			<?load_theme_view('inc/tpl-noscript')?>
			
			<?if($BC->is_home_page()):?>
            	<?load_theme_view('inc/box-jcarousel')?>
            <?endif?>
			
			<!-- Content -->
			<?load_theme_view($tpl_page)?>
			<!-- End Content -->
			
		</div>
		
		<div id="right-sidebar" class="sidebar">
		
			<?load_theme_view('inc/right-sidebar')?>
					
		</div>
	
	</div>
	
﻿	<div id="footer">
	
		<div class="menu">
			
			<?=get_menu('bottom','separator')?>
		
		</div>
		
		<div class="copyright">
			Copyright &copy; 2010-<?=date('Y')?> EKOMAG
			<br />ЕКО Магазин / Ternopil / Тернопіль
			<br /><small style="font-size:80%">Використання матеріалів сайту дозволяється лише з прямим і активним посиланням на сайт.</small>
		</div>
		
		<div class="partners">
		
			<br /><br />﻿
			
			<!-- Yandex.Metrika counter -->
			<div style="display:none;"><script>
			(function(w, c) {
			    (w[c] = w[c] || []).push(function() {
			        try {
			            w.yaCounter11153020 = new Ya.Metrika({id:11153020, enableAll: true});
			        }
			        catch(e) { }
			    });
			})(window, "yandex_metrika_callbacks");
			</script></div>
			<script src="//mc.yandex.ru/metrika/watch.js" defer="defer"></script>
			<noscript><div><img src="//mc.yandex.ru/watch/11153020" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
			<!-- /Yandex.Metrika counter -->


			<a href="http://109.te.ua" target="_blank">
				<img width="88" height="31" border="0" alt="Адреси, телефони підприємств, організацій, квартирних телефонів Тернополя і Тернопільської області" src="http://109.te.ua/userfiles/image/banner/109AnimBut88x31.gif" />
			</a>

			<a href="http://www.katalog.te.ua/cncat_from.php?34619" target="_blank">
				<img src="http://www.katalog.te.ua/images/88_31_2.gif" width="88" height="31" border="0" alt="Каталог веб ресурсів Тернопільщини" />
			</a>

			<a href="http://top.ternopil.ua/cncat_from.php?9771" target="_blank">
				<img src="http://top.ternopil.ua/top.gif" width="88" height="31" border="0" alt="" />
			</a>
		
		</div>
	
	</div>

</div>

</body>
</html>