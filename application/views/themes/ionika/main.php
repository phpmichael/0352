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

<body id="body">
    <div id="dialog"></div>

    <div class="header-splash">
        <div class="main">
        	<?load_theme_view('inc/tpl-noscript')?>
        
            <!-- header -->

            <div id="header">
                <div class="header-1">
                    <?=anchor($BC->_getBaseURL(),img(array('src'=>$BC->_getTheme().'images/header.png','width'=>940,'height'=>99,'alt'=>'IONIKA')))?>
                    <div class="top-right">
                    	<span><?=img(array('src'=>$BC->_getTheme().'images/con_tel.png','width'=>20,'height'=>20,'class'=>'move-down'))?> <?=$BC->settings_model['site_phone1']?>, <?=$BC->settings_model['site_phone2']?>, </span> 
                    	<a href="javascript:;" class="request-call"><?=language('request_a_call')?></a>
                    	<a href="http://vk.com/klavishko"><?=img(array('src'=>$BC->_getTheme().'images/vkontakte.png','width'=>24,'height'=>24,'class'=>'move-down'))?> vk.com/klavishko</a>
                    	<a href="http://facebook.com/klavishko"><?=img(array('src'=>$BC->_getTheme().'images/facebook.png','width'=>24,'height'=>24,'class'=>'move-down'))?> facebook.com/klavishko</a>
                    	<a href="<?=base_url().($BC->_getInterfaceLang(TRUE)=='ua'?'':'ua/')?>" title="<?=language('ukrainian')?>"><?=img(array('src'=>'images/flags/ua.png','width'=>18,'height'=>12))?></a> 
                        <a href="<?=base_url().($BC->_getInterfaceLang(TRUE)=='ru'?'':'ru/')?>" title="<?=language('russian')?>"><?=img(array('src'=>'images/flags/ru.png','width'=>18,'height'=>12))?></a>
                    </div>
                    
                    <div class="middle-right">
                    	
                    </div>
                    
                    <?load_theme_view('inc/box-products-search')?>
                </div>
                <div class="border-top">
                    
                    <?load_theme_view('inc/top-menu')?>
                
                </div>

                <?if (false):?>
                <div class="border-bot">
                
                    <div id="slider">
			
        				<?
        					$slideshow = load_model('slideshow_model');
        					$slides = $slideshow->getAll();
        				?>
        			
        				<?foreach ($slides as $slide):?>
        				<div>
        					<a href="<?=$slide['link']?>" title="<?=htmlspecialchars($slide['title'])?>"><img src="<?=base_url()?>images/data/m/slideshow/<?=$slide['image']?>" alt="<?=htmlspecialchars($slide['title'])?>" /></a>
        				</div>
        				<?endforeach?>
        			
        			</div>

                </div>
                <?else:?>
                	<div style="height:10px"></div>
                <?endif?>
            </div><!-- END header -->

            <div id="content">

                <div class="wrapper">
                    <?if(!$BC->is_home_page()):?>
                        <?load_theme_view('inc/tpl-cur-location')?>
                    <?endif?>   
                
                
                    <?load_theme_view('inc/right-sidebar')?>

                    <div class="container">
                        <?if ($BC->is_home_page()):?>
                            <?load_theme_view('inc/home')?>
                        <?else:?>
                            <?load_theme_view($tpl_page)?>
                        <?endif?>
                    </div>
                </div>
            </div>

            <div id="footer">
                <div class="wrapper">
                    <ul class="menu">
                        <?=get_menu('bottom',"<li><a href='{link}'><span>{title}</span></a></li>")?>
                    </ul>

                    <div class="footerText">
                        Copyright &copy; 2012 "Іоніка". All Rights Reserved.
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>
