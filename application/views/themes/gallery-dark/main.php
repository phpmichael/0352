<?
$BC->load->helper('blog');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?load_theme_view('inc/tpl-head'); ?>
</head>
<body>
<div id="container">
	<div id="header">
		<div id="logo"><h1><?=$head['site_title']?></h1></div> 
		<div id="navbar">
			<?load_theme_view('inc/box-menu')?>
		</div>
		<div align="right"></div>
		<div class="clear"></div>
		<div class="clear"></div>
	</div>
	
	<?if($tpl_page=='photos/list'):?>
	   <?load_theme_view('tpl-gallery');?>
	<?else:?>
	<div id="content">
	   <?load_theme_view($tpl_page);?>
	</div>
	
	<div id="sidebar">

		<?if( $this->session->userdata('customer_id') ):?>
			<?load_theme_view('inc/customer-menu')?>
		<?else:?>
			<?load_theme_view('inc/box-login')?>
		<?endif?>
		
	</div>
	<?endif?>
	
	<?load_theme_view('tpl-footer')?>
</div>
</body>
</html>