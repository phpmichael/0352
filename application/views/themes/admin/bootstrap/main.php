<!DOCTYPE html>
<html>
<head>

	<title><?=$BC->_getPageTitle()?></title>
	
	<?=include_css($BC->_getTheme().'css/bootstrap.min.css')?>
	
	<?foreach ($BC->_getCSSFiles() as $css_file):?>
        <?=include_css($css_file)?>
    <?endforeach?>
    
    <?$this->load->view('inc/js-jquery')?>
	<?$this->load->view('inc/js-flash-msg')?>
	
	<?=include_js($BC->_getTheme().'js/bootstrap.min.js')?>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
        
                <header>
                
                	<div class="span9">
                		<?load_theme_view('inc/navmenu-h')?>
                	</div>
                	
                	<div class="span3">
                		<b class="title"><?=language('section')?>:  <?=$BC->_getPageTitle()?></b>
                		
                		<ul id="menu-right"><?=$BC->_built_right_menu()?></ul> 
                	</div>
                	
                </header>
                
                <section>
                			
                	<?load_theme_view($tpl_page);?>		
                			
                </section>
                
                <footer>
                	<p>Page rendered in {elapsed_time}. Memory usege {memory_usage}.</p>
                </footer>
            
            </div>
        </div>
    </div>

</body>

</html>