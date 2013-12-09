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
                <div class="border-top">
                    <div id="logo" onclick="location.href='<?=base_url().$BC->_getBaseURL()?>'"></div>
                    
                    <div class="site-phones">
                        <div><?=$BC->settings_model['site_phone1']?></div>
                        <div><?=$BC->settings_model['site_phone2']?></div>
                        <div><?=$BC->settings_model['site_phone3']?></div>
                    </div>
                    
                    <div class="lang-select">
                    	<a href="<?=base_url().'ua/'?>" title="<?=language('ukrainian')?>"><?=img('images/flags/ua.png')?></a> 
                        <a href="<?=base_url().'ru/'?>" title="<?=language('russian')?>"><?=img('images/flags/ru.png')?></a>
                        &nbsp;&nbsp;
                        <a href="<?=site_url('articles/RSS')?>" title="RSS <?=language('articles')?>"><?=img($BC->_getTheme().'images/feed-icon-14x14.png')?></a>
                    </div>

                    <?load_theme_view('inc/box-short-cart')?>
                </div>

                <div class="border-bot">
                    <div id="topmenu">
                        <div class="moduletable-nav">
                            <ul class="menu">
                                <li><?=anchor_base('customers','<span>'.language('my_account').'</span>')?></li>
                                <li><?=anchor_base('cart','<span>'.language('shopping_cart').'</span>')?></li>
                                <li><a href="javascript:void(0)" class="request-call"><span><?=language('request_a_call')?></span></a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <?load_theme_view('inc/box-products-search')?>
                    
                    <?load_theme_view('inc/top-menu')?>

                </div>
            </div><!-- END header -->

            <div id="content">

                <div class="wrapper">
                    <?if(!$BC->is_home_page()):?>
                        <?load_theme_view('inc/tpl-cur-location.php')?>
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

            <div class="wrapper">
                <div id="footer">
                    <div class="space">
                        <div class="wrapper">
                            <div class="footerText">
                                <ul class="menu">
                                    <?=get_menu('bottom',"<li><a href='{link}'><span>{title}</span></a></li>")?>
                                </ul>

                                <div>
                                    Copyright &copy; 2011 "Белый кот". All Rights Reserved.
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
