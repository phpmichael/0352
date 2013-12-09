<?
$BC->load->helper('customer');
$BC->load->helper('blog');
$BC->load->helper('poll');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<?load_theme_view('inc/tpl-head'); ?>
</head>

<body>

<div id="outer">

	<div id="header">
	
		<h1><a href="<?=base_url()?>"><?=$head['site_title']?></a></h1>
		<h2><?=$head['meta_description']?></h2>
		
		<div id="rss-icons">
			<div><?=anchor_base('news/RSS',language('news'))?></div>
			<div><?=anchor_base('articles/RSS',language('articles'))?></div>
		</div>
		
	</div>
	
	<div id="content">
	
		<div id="tertiaryContent">

			<?if( $this->session->userdata('customer_id') ):?>
				<?load_theme_view('inc/customer-menu')?>
			<?else:?>
				<?load_theme_view('inc/box-login')?>
			<?endif?>
			
			<?if(in_array($BC->_getController(),array('products','customers'))):?>
			<div>
				<?load_theme_view('inc/box-short-cart')?>
			</div>
			<?endif?>
			
			<div>
				<?load_theme_view('inc/box-poll')?>
			</div>
			
			<?if(in_array($BC->_getController(),array('products'))):?>
			<div>
				<?load_theme_view('inc/box-random-testimonial')?>
			</div>
			<?endif?>
			
			<div class="xbg"></div>
			
		</div>
		
		<div id="primaryContentContainer">
		
			<div id="primaryContent">
			
				<?load_theme_view($tpl_page);?>
				
			</div>
			
		</div>
		
		<div id="secondaryContent">
			
			<?load_theme_view('inc/box-menu')?>
			
			<ul>
                <?if($BC->_getMethod()!='unsubscribe'):?>
				<li>
					<?load_theme_view('inc/box-subscribe')?>
				</li>
                <?endif?>
				
                <?if(in_array($BC->_getController(),array('products','articles','news'))):?>
                <div class="tag_cloud">
                	<h2><?=language('tags_cloud')?></h2>
                	<?=tags_cloud()?>
                </div>
                <?endif?>
                
                <?if(in_array($BC->_getController(),array('articles','news'))):?>
				<li>
					<h2><?=language('archives')?></h2>
					<ul><?=get_archives($blog_model);?></ul>
				</li>
				<li>
					<h2><?=language('categories')?></h2>
					<?=get_categories_tree($blog_model);?>
				</li>
                <?endif?>
                
			</ul>
			
			<?if(in_array($BC->_getController(),array('articles','news'))):?>
				<div class='calendar-box'>
                	<?=posts_calendar($blog_model)?>
                </div>
            <?endif?>
			
			<div class="xbg"></div>
			
		</div>
		
		<div class="clear"></div>
		
	</div>
	
	<?load_theme_view('inc/tpl-footer')?>
	
</div>

</body>
</html>