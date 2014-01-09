<?
$BC->load->helper(array('customer','blog','social','formbuilder'));
$BC->lang->load('calendar');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?=$BC->_getPageTitle()?></title>

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
	
	<?=include_minified($BC->_getTheme().'css/bootstrap.css','css')?>
	
	<?=include_minified($BC->_getTheme().'css/styles.css','css')?>
	
	<!-- CSS -->
	<?foreach ($BC->_getCSSFiles() as $css_file):?>
	<?=include_minified($css_file,'css')?>
	<?endforeach?>
	<?=include_minified('css/dialog-cart.css','inline_css')?>
	
	<?$this->load->view('inc/js-jquery')?>
	<?//$this->load->view('inc/js-proxino'); ?>
	<?$this->load->view('inc/js-flash-msg')?>
	<?$this->load->view('inc/js-tooltip')?>
	
	<?=include_js($BC->_getTheme().'js/bootstrap.min.js')?>
	
	<?if( in_array($BC->_getController(),array('products','books')) && in_array($BC->_getMethod(),array('view','name'))):?>
	<?$this->load->view('inc/js-lightbox')?>
	<?endif?>
	
	<?$this->load->view('inc/js-facebox'); ?>
	
	<?=include_minified($BC->_getFolder('js').'custom/cart/show_short_cart.js','js')?>
	
	<!-- Load Application Packages config -->
    <script src="<?=base_url().$BC->_getBaseURL().'app_js/config'?>"></script>
	
	<?foreach ($BC->_getJSFiles() as $js_file):?>
	<?=include_js($js_file)?>
	<?endforeach?>
	
	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    <?=inline_js($BC->_getTheme().'js/categories-nav.js')?>
    
    <script>
    $j(document).ready(function(){
        <?if(in_array($BC->_getController(),array('products','books')) && in_array($BC->_getMethod(),array('index','search')) && @$search_category_id):?>
        open_level1_node($j("#products-categories a.active"));
        <?endif?>
    });
    </script>

    <!-- Slider -->
    <?=include_js($BC->_getTheme().'js/jquery.cycle.all.min.js')?>
    <?=inline_js($BC->_getTheme().'js/slider.js')?>

</head>

<body>

    <div id="page" class="container-fluid">
        <div class="row-fluid">
            <div>

                <nav>
                    <div class="navbar">
                        <div class="navbar-inner">
                            <div class="container">
                                <div class="nav-collapse wrapper">
                                    <ul class="nav">
                                        <?=get_menu('left',"<li><a href='{link}'><span>{title}</span></a></li>")?>
                                    </ul>
                                    <ul class="nav navbar-nav pull-right">
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="choose-lang">
                                                <?=img(array('src'=>'images/flags/'.strtolower($BC->lang_model->getLangCodeByLanguage($BC->config->item('language'))).'.png','width'=>18,'height'=>12))?> <?=language($BC->config->item('language'))?>
                                                <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="choose-lang">
                                                <?if($BC->config->item('language')!='ukrainian'):?>
                                                <li>
                                                    <a href="<?=base_url().($BC->lang_model->getDefaultLangCode()=='UA'?'':'ua/')?>" title="<?=language('ukrainian')?>">
                                                        <?=img(array('src'=>'images/flags/ua.png','width'=>18,'height'=>12))?> <?=language('ukrainian')?>
                                                    </a>
                                                </li>
                                                <?endif?>
                                                <?if($BC->config->item('language')!='russian'):?>
                                                <li>
                                                    <a href="<?=base_url().($BC->lang_model->getDefaultLangCode()=='RU'?'':'ru/')?>" title="<?=language('russian')?>">
                                                        <?=img(array('src'=>'images/flags/ru.png','width'=>18,'height'=>12))?> <?=language('russian')?>
                                                    </a>
                                                </li>
                                                <?endif?>
                                            </ul>
                                        </li>
                                    </ul>

                                </div><!-- /.nav-collapse -->
                            </div>
                        </div><!-- /navbar-inner -->
                    </div>
                </nav>
        
                <header>

                	<div class="wrapper row-fluid">
                        <div class="span4" id="logo">
                            <a class="main-logo" href="<?=base_url()?>"></a>
                            <div class="main-logo-text">
                                <?if($BC->_getInterfaceLang()=='ua'):?>
                                    Інтернет–магазин навчально-методичної літератури
                                <?else:?>
                                    Интернет-магазин учебно-методической литературы
                                <?endif?>
                            </div>
                        </div>

                        <div class="span5">
                            <?load_theme_view('inc/phones')?>
                        </div>

                        <div class="span3">
                            <div id="cart"></div>
                        </div>
                	</div>

                    <div class="info-bar">

                    </div>
                	
                </header>
                	
                <div class="clearfix wrapper">
                	
	            	<aside class="left-sidebar">
	            	
	            		<?load_theme_view('inc/left-sidebar')?>
	            	
	            	</aside>
	            		
	            	<div class="main">
	            		<?if ($BC->is_home_page()):?>
                            <?load_theme_view('inc/home')?>
                        <?else:?>
                        	<?load_theme_view('inc/tpl-cur-location')?>
                        
                            <?load_theme_view($tpl_page)?>
                        <?endif?>
	            	</div>	
	            	
	            	<aside class="right-sidebar">
					    
					    <?load_theme_view('inc/right-sidebar')?>
	            	
	            	</aside>	
            	
            	</div>


                <?if($BC->is_home_page() &&  isset($body) && trim($body)):?>
                <div class="wrapper">
                    <h2 class="head-about"><span><?=language('about_shop')?></span></h2>
                    <?=$body?>
                </div>
                <?endif?>
                
                <footer>
                    
                    <div class="navbar navbar-inverse">
                        <div class="navbar-inner">
                            <div class="container">
                                <div class="nav-collapse">
                                    <ul class="nav">
                                        <?=get_menu('bottom',"<li><a href='{link}'><span>{title}</span></a></li>")?>
                                    </ul>
                                </div><!-- /.nav-collapse -->
                            </div>
                        </div><!-- /navbar-inner -->
					</div>

                    <div class="row-fluid">
                        <div class="wrapper">
                            <div class="span4" id="logo">
                                <div class="small-logo"></div>
                                <div class="small-logo-text">
                                    <?if($BC->_getInterfaceLang()=='ua'):?>
                                        Інтернет–магазин навчально-методичної літератури
                                    <?else:?>
                                        Интернет-магазин учебно-методической литературы
                                    <?endif?>
                                </div>
                            </div>

                            <div class="span5">
                                <?load_theme_view('inc/phones')?>
                            </div>

                            <div class="span3">
                                <div><?=language('follow_us')?></div>
                                <div class="row-fluid">
                                    <a class="social-icon social-google" href="#"></a>
                                    <a class="social-icon social-twitter" href="#"></a>
                                    <a class="social-icon social-vkontakte" href="#"></a>
                                    <a class="social-icon social-odnoklasniki" href="#"></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="copyright">
                        &copy; 2014 navchalka.com, <?=language('all_rights_reserved')?>
                    </div>
					  
                </footer>
            
            </div>
        </div>
    </div>

</body>

</html>