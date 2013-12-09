<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="robots" content="index,follow" />
	
	<title><?=$head['site_title']?><?if($head['page_title']):?> :: <?=$head['page_title']?><?endif?></title>
    
	<meta name='description' content='<?=$head['meta_description']?>' />
    <meta name='keywords' content='<?=$head['meta_keywords']?>' />
    
    <!-- CSS Styles -->
	<?=include_css('css/zero.css')?>
	<?=include_css($BC->_getTheme().'css/style.css')?>
	
	<?foreach ($BC->_getCSSFiles() as $css_file):?>
	<?=include_css($css_file)?>
	<?endforeach?>
    
    <?$this->load->view('inc/js-jquery')?>
    
    <!-- Load Application Packeges config -->
	<?=include_js($BC->_getBaseURL().'app_js/config')?>
	
	<?foreach ($BC->_getJSFiles() as $js_file):?>
	<?=include_js($js_file)?>
	<?endforeach?>
	
</head>
<body>

<div id="wrapper">
<div id="wrapper-top">
<div id="wrapper-btm">

<!-- start header -->
<div id="header">
	<h1>Modern </h1>
	<p> design By Free CSS Templates</p>
</div>
<!-- end header -->
<!-- start page -->

	<div id="page">
		<div class="bgtop">
			<div class="bgbtm">
				<!-- start content -->
				<div id="content">
					<?load_theme_view($tpl_page)?>
				</div>
				<!-- end content -->
				<!-- start sidebar -->
				<div id="sidebar">
					<ul>
						<li>
							<h2>Menu</h2>
							<ul>
								<?=get_menu('left')?>
							</ul>
						</li>
						<li>
							<h2>Blogroll</h2>
							<ul>
								<li><a href="#">Aliquam liberonare</a></li>
								<li><a href="#">Consectetuer adipiscing</a></li>
								<li><a href="#">Metusin  pellentesque</a></li>
								<li><a href="#">Suspendisse  maurisres</a></li>
								<li><a href="#">Urnanet  molestie semper</a></li>
								<li><a href="#">Proin gravida  porttitor</a></li>
							</ul>
						</li>
					</ul>
				</div>
				<!-- end sidebar -->
				<div style="clear:both">&nbsp;</div>
			</div>
		</div>
	</div>
<div id="footer">
	<p>&copy;2012 All Rights Reserved</div>
</p>
</div>
</div>
</div>
</div>
</body>
</html>