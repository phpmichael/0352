<?
$BC->load->helper('customer');
$BC->load->helper('blog');
$BC->load->helper('poll');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?load_theme_view('inc/tpl-head')?>
</head>

<body class="cms-index-index cms-home">
    <div class="wrapper">
    
        <?load_theme_view('inc/tpl-noscript')?>

        <div class="header">
            <div class="header-wrapper">
                <div class="page">
                    <div class="col-1">
                        <h1 class="logo">
                            <strong>HealthLife</strong>
                            <a href="<?=base_url().$BC->_getBaseURL()?>" title="HealthLife" class="logo">
                                <img src="<?=base_url().$BC->_getTheme()?>images/logo.gif" alt="HealthLife" />
                            </a>
                        </h1>
                    </div>

                    <div class="col-2">
                        <div class="links-block">
                            <div class="content">
                                <ul class="links">
                                    <li class="first">
                                    <?=anchor_base('customers', language('my_account'))?>
                                    </li>

                                    <li>
                                    <?=anchor_base('wishlist', language('my_wishlist'))?>
                                    </li>

                                    <li>
                                    <?=anchor_base('cart', language('shopping_cart'))?>
                                    </li>

                                    <li class="last">
                                    <?=anchor_base('customers/signin', language('login'))?>
                                    </li>
                                </ul>

                                <div class="clear"></div>
                            </div>

                            <div class="corners"></div>
                        </div>

                        <div class="clear"></div>
 
                        <p class="welcome-msg">
                            <a href="<?=base_url().'ua/'?>" title="<?=language('ukrainian')?>"><?=img('images/flags/ua.png')?></a> 
                            <a href="<?=base_url().'ru/'?>" title="<?=language('russian')?>"><?=img('images/flags/ru.png')?></a>
                            
                            Welcome to our online store!
                        </p>
                        
                        <?=load_theme_view('inc/box-currency-select')?>
                    </div>

                    <div class="clear"></div>
                </div>
            </div>

           <?load_theme_view('inc/top-menu');?>
        </div>

        <?if ($BC->is_home_page()):?>
            <?load_theme_view('layout-home');?>
        <?elseif(in_array($BC->_getController(),array('pages','products'))):?>
            <?load_theme_view('layout-2-sidebars');?>
        <?elseif (in_array($BC->_getController(),array())):?>
            <?load_theme_view('layout-left-sidebar');?>
        <?elseif (in_array($BC->_getController(),array('contact_us','customers','tell_friend','wishlist','orders','articles','cart','subscribe'))):?>
            <?load_theme_view('layout-right-sidebar');?>
        <?else:?>
            <?load_theme_view('layout-no-sidebar');?>
        <?endif?>

        <div class="page">
            <div class="footer">
                <?load_theme_view('inc/footer');?>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
    //<![CDATA[
         
        /*function lastblock(sidebarName){                
                var searchColumn = document.getElementsByClassName(sidebarName)[0];             
                var sidebarBlocks = searchColumn.getElementsByClassName('block');                       
                if(sidebarBlocks.length > 0){
                        sidebarBlocks[sidebarBlocks.length-1].className += ' last-block';
                }
        }
        lastblock('col-left');*/
    //]]>
    </script>
    
</body>
</html>