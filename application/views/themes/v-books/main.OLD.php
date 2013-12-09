<?
$BC->load->helper(array('customer','blog','poll','social','formbuilder'));
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?=$BC->_getPageTitle()?></title>
	
	<?=include_minified($BC->_getTheme().'css/bootstrap.css','css')?>
	
	<?=include_minified($BC->_getTheme().'css/styles.css','css')?>
	
	<!-- CSS -->
	<?=include_minified($BC->_getTheme().'css/poll.css','inline_css')?>
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
	
	<?=inline_js($BC->_getFolder('js').'custom/cart/show_short_cart.js')?>
	
	<!-- Load Application Packeges config -->
	<?=include_js($BC->_getBaseURL().'app_js/config')?>
	
	<?foreach ($BC->_getJSFiles() as $js_file):?>
	<?=include_js($js_file)?>
	<?endforeach?>
	
	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    <?=include_js($BC->_getTheme().'js/categories-nav.js')?>
    
    <script type="text/javascript">
    $j(document).ready(function(){
        <?if(in_array($BC->_getController(),array('products','books')) && in_array($BC->_getMethod(),array('index','search')) && @$search_category_id):?>
        open_level1_node($j("#products-categories a.active"));
        <?endif?>
    });
    </script>

</head>

<body>

    <div id="page" class="container-fluid">
        <div class="row-fluid">
            <div>
        
                <header>
                
                	<div class="span2" id="logo">
                		<h1>Buy Books</h1>
                		
                		<div>
                			<a href="<?=base_url().($BC->settings_model['default_lang']=='UA'?'':'ua/')?>" title="<?=language('ukrainian')?>"><?=img(array('src'=>'images/flags/ua.png','width'=>18,'height'=>12))?> <?=language('ukrainian')?></a> 
                        	<a href="<?=base_url().($BC->settings_model['default_lang']=='RU'?'':'ru/')?>" title="<?=language('russian')?>"><?=img(array('src'=>'images/flags/ru.png','width'=>18,'height'=>12))?> <?=language('russian')?></a>
                		</div>
                	</div>
                	
                	<div class="span7" id="middle-header">
                	  <div class="navbar">
					    <div class="navbar-inner">
					      <div class="container">
					        <div class="nav-collapse">
					          <ul class="nav">
					            <?=get_menu('left',"<li><a href='{link}'><span>{title}</span></a></li>")?>
					          </ul>
					          	<?if (!in_array($BC->_getController(),array('articles'))):?>
									<?=form_open($BC->_getBaseURL()."books/search",array('class'=>'navbar-search pull-left'))?>
								<?else:?>
									<?=form_open($BC->_getBaseURL()."articles",array('class'=>'navbar-search pull-left'))?>
								<?endif?>
									  <?=form_input("keywords",trim(urldecode(@$keywords)),"class='search-query input-medium' placeholder='".language('search')."'")?> 						
								</form>
					        </div><!-- /.nav-collapse -->
					      </div>
					    </div><!-- /navbar-inner -->
					  </div>
                	</div>
                	
                	<div class="span3">
                	   <div class="well" id="cart"></div>
                	</div>
                	
                </header>
                	
                <div class="clearfix">
                	
	            	<aside class="span3">
	            	
	            		<?load_theme_view('inc/left-sidebar')?>
	            	
	            	</aside>
	            		
	            	<div class="span6" id="content">
	            		<?if ($BC->is_home_page()):?>
                            <?load_theme_view('inc/home')?>
                        <?else:?>
                        	<?load_theme_view('inc/tpl-cur-location')?>
                        
                            <?load_theme_view($tpl_page)?>
                        <?endif?>
	            	</div>	
	            	
	            	<aside class="span3">
					    
					    <?load_theme_view('inc/right-sidebar')?>
	            	
	            	</aside>	
            	
            	</div>			
                
                <footer>
                    
                    <div class="navbar navbar-inverse">
					    <div class="navbar-inner">
					      <div class="container">
					        
					        <a class="brand" href="#">Buy Books</a>
					        <div class="nav-collapse">
					          <ul class="nav pull-right">
					            <?=get_menu('bottom',"<li><a href='{link}'><span>{title}</span></a></li>")?>
					          </ul>
					        </div><!-- /.nav-collapse -->
					      </div>
					    </div><!-- /navbar-inner -->
					  </div>
					  
                </footer>
            
            </div>
        </div>
    </div>

</body>

</html>