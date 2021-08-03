<?
$BC->load->helper(array('customer','blog','social','formbuilder'));
$BC->lang->load('calendar');
?>
<!DOCTYPE html>
<html lang="<?=$BC->lang_model->getCurrentLangCode()?>">
<head>

    <?load_theme_view('inc/tpl-head')?>

</head>

<body>

    <div id="page" class="container-fluid">
        <div class="row-fluid">
            <div>
        
                <header>

                    <?load_theme_view('inc/tpl-noscript')?>

                    <div class="info-bar">
                        <div class="wrapper row-fluid">
                            <div class="span2">
                                <?if($BC->config->item('language')!='ukrainian'):?>
                                    <a href="<?=base_url().($BC->lang_model->getDefaultLangCode()=='UA'?'':'ua/')?>" title="<?=language('ukrainian')?>">
                                        UA
                                    </a>
                                <?endif?>
                                <?if($BC->config->item('language')!='russian'):?>
                                    <a href="<?=base_url().($BC->lang_model->getDefaultLangCode()=='RU'?'':'ru/')?>" title="<?=language('russian')?>">
                                        RU
                                    </a>
                                <?endif?>
                            </div>
                            <div class="span7">
                                <?load_theme_view('inc/phones-line')?>
                            </div>
                            <div class="span3">

                            </div>
                        </div>
                    </div>

                	<div class="wrapper row-fluid header">
                        <div class="span3">
                            <a class="main-logo" href="<?=base_url()?>"></a>
                        </div>

                        <div class="span6">
                            <?load_theme_view('inc/search')?>
                            <div>
                                <a class="request-call" href="#"><?=language('request_a_call')?></a> <br/>
                                <?=anchor_base($BC->config->item('language')=='ukrainian'?'page/vidstezhiti-vantazh':'page/otsledit-gruz', language('track_shipment'))?>
                            </div>
                        </div>

                        <div class="span3">
                            <div id="cart"></div>
                        </div>
                	</div>

                    <nav>
                        <div class="navbar">
                            <div class="navbar-inner">
                                <div class="container">
                                    <div class="nav-collapse wrapper">

                                        <h2 class="catalog"><i class="icon-list icon-white"></i><?=language('catalog')?></h2>

                                        <ul class="nav">
                                            <?=get_menu('left',"<li><a href='{link}'><span>{title}</span></a></li>")?>
                                        </ul>

                                    </div><!-- /.nav-collapse -->
                                </div>
                            </div><!-- /navbar-inner -->
                        </div>
                    </nav>
                	
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
            	
            	</div>
                
                <footer>

                    <div class="row-fluid">
                        <div class="wrapper">
                            <div class="span3">
                                <h3><?=language('shop')?></h3>
                                <ul class="nav">
                                    <?=get_menu('bottom',"<li><a href='{link}'>{title}</a></li>")?>
                                </ul>
                            </div>

                            <div class="span5">
                                <?load_theme_view('inc/phones')?>
                            </div>

                            <div class="span4">
                                <div class="logo-bottom"></div>
                            </div>
                        </div>
                    </div>

                    <div class="copyright">
                        &copy; 2015 znobooks.com.ua, <?=language('all_rights_reserved')?>
                    </div>
					  
                </footer>
            
            </div>
        </div>
    </div>

</body>

</html>