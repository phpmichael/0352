<?$BC->load->helper('blog');?>
<!DOCTYPE html>
<html>
<head>
    <?load_theme_view('inc/tpl-head'); ?>
</head>

<body>
	<div id="page">
		
		<div id="header" onclick="location.href='<?=base_url()?>'"></div>	
		
		<div id="menu">		
					
			<div id="menu_main"><a href="<?=base_url()?>"></a></div>
			<div id="menu_contacts"><a href="<?=site_url('contact_us')?>"></a></div>
			<div id="menu_prices"><a href="<?=site_url('page/cini')?>"></a></div>
			<div class="clear"></div>

            <?//load_theme_view('inc/tpl-tags-cloud'); ?>
			
			<?load_theme_view('inc/tpl-partners'); ?>
			
		</div>
		
		<div id="content">
			<?load_theme_view($tpl_page); ?>
		</div>
				
		<div id="footer">
			Copyright &copy; 2008 - <script>d = new Date();document.write(d.getFullYear())</script>
		</div>
		
	</div>
</body>
</html>