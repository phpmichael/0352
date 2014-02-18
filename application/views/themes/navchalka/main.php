<?
$BC->load->helper(array('customer','blog','social','formbuilder'));
$BC->lang->load('calendar');
?>
<!DOCTYPE html>
<html>
<head>

    <?load_theme_view('inc/tpl-head')?>

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
                                        <?if($BC->config->item('language')!='ukrainian'):?>
                                            <li>
                                                <a href="<?=base_url().($BC->lang_model->getDefaultLangCode()=='UA'?'':'ua/')?>" title="<?=language('ukrainian')?>">
                                                    <i class="flag-ua"></i> <?=language('ukrainian')?>
                                                </a>
                                            </li>
                                        <?endif?>
                                        <?if($BC->config->item('language')!='russian'):?>
                                            <li>
                                                <a href="<?=base_url().($BC->lang_model->getDefaultLangCode()=='RU'?'':'ru/')?>" title="<?=language('russian')?>">
                                                    <i class="flag-ru"></i> <?=language('russian')?>
                                                </a>
                                            </li>
                                        <?endif?>
                                    </ul>

                                </div><!-- /.nav-collapse -->
                            </div>
                        </div><!-- /navbar-inner -->
                    </div>
                </nav>
        
                <header>

                	<div class="wrapper row-fluid">
                        <div class="span4">
                            <a class="main-logo" href="<?=base_url()?>"></a>
                            <div class="main-logo-text">
                                <?if($BC->config->item('language')=='ukrainian'):?>
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
                    <h2 class="fancy"><span><?=language('about_shop')?></span></h2>
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
                            <div class="span4">
                                <div class="small-logo"></div>
                                <div class="small-logo-text">
                                    <?if($BC->config->item('language')=='ukrainian'):?>
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