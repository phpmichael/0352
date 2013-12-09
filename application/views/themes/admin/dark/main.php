<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

	<title><?=$BC->_getPageTitle()?></title>
	
	<?$this->load->view('inc/js-IE-fix')?>
	<?$this->load->view('inc/js-jquery')?>
	<?$this->load->view('inc/js-flash-msg')?>
	
	<?=include_css('css/zero.css')?>
	<?=include_css($BC->_getTheme().'styles.css')?>
	<?if($tpl_page=='managers/signin'):?>
	   <?=include_css($BC->_getTheme().'login.css')?>
	<?endif?>
	
	<?foreach ($BC->_getCSSFiles() as $css_file):?>
        <?=include_css($css_file)?>
    <?endforeach?>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<?if($tpl_page=='managers/signin'):?>

<body id="login-bg">		
	<?load_theme_view($tpl_page);?>				
</body>

<?else:?>

<body>

    <div id="header">
    
    	<div id="header_left">
    		<?load_theme_view('inc/navmenu-h')?>
    	</div>
    	
    	<div id="header_right">
    		<b class="title"><?=language('section')?>:  <?=$BC->_getPageTitle()?></b>
    		
    		<ul id="menu-right"><?=$BC->_built_right_menu()?></ul> 
    	</div>
    	
    </div>
    
    <div id="outer">
    			
    	<?load_theme_view($tpl_page);?>		
    			
    </div>
    
    <div id="footer">
    	<p>Page rendered in {elapsed_time}. Memory usege {memory_usage}.</p>
    </div>

</body>

<?endif?>
</html>