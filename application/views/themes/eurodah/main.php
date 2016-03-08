<?
$BC->load->helper('poll');
$BC->load->helper('social');
$BC->load->helper('text');
?>
<!DOCTYPE html>
<html>
<head>
	<?load_theme_view('inc/tpl-head')?>
</head>

<body>
    <?load_theme_view('inc/tpl-noscript')?>
    <div id="page-wrapper">
        <div id="page">
			<header id="header">
				<div class="section-1 clearfix">
					<div class="col1">
						<a href="<?=base_url()?>" title="<?=language('home_page')?>" rel="home" id="logo"><?=img(array('src'=>$BC->_getTheme()."images/eurodah_logo.jpg",'width'=>129,'height'=>106))?></a>
					</div>

                    <div id="header-title">
                        <div>Металочерепиця - Тернопіль</div>
                        <div>Євродах</div>
                    </div>

					<div class="col2">
						<div class="region region-search">
							<div id="block-search-form">
								<div class="content">
									<form action="<?=site_url('assortment/search')?>" method="post" id="search-block-form">
										<div>
											<div class="container-inline">
												<div> 
													<input name="keywords" value="<?=trim(urldecode(@$keywords))?>" size="15" maxlength="128" class="form-text" type="text" />
												</div>
												<div>
													<input value="Search" class="form-submit" type="submit" />
												</div>
											</div>
										</div>
									</form>
								</div><!-- /.content -->
							</div><!-- /.block -->
						</div>

						<div class="clear2"></div>

						<!--
						<div class="welcome-msg">
							Hi Anonymous
						</div>

						<ul id="secondary-menu" class="links clearfix">
							<li class="first"><a href="" title="">New User</a></li>
							<li class="last"><a href="" title="">Login</a></li>
						</ul>
						-->
						
						<?if($BC->is_home_page()):?>
						<div style="margin:10px 0 0 35px;"><?social_buttons()?></div>
						<?endif?>
					</div>
				</div>
			

				<div class="section-2 clearfix">
					<div class="region region-menu">
						<?load_theme_view('inc/top-nav')?>

						<!--
						<div id="block-follow-site" class="block block-follow block-odd">
							<div class="content">
								<div class="follow-links clearfix">
									<a href="http://facebook.com/" class="follow-link follow-link-facebook follow-link-site" title="Follow Perfect Biz on Facebook">Facebook</a> 
									<a href="http://twitter.com/" class="follow-link follow-link-twitter follow-link-site" title="Follow Perfect Biz on Twitter">Twitter</a>
								</div>
							</div>>
						</div>
						-->
						
					</div>
				</div><!-- /.section -->

				<div class="clear"></div><!-- /.section -->
				
				<?if($BC->is_home_page()):?>
                    <?load_theme_view('inc/home-1')?>
				<?endif?>

				<p id="skip-link"><em><a href="#navigation">Skip to Navigation</a></em></p><!-- /#header -->
				
			</header>
			
            <div id="main-wrapper">
                <div id="main">
                    
                    <?if($BC->is_home_page()):?>
                        <?load_theme_view('inc/home-2')?>
    				<?endif?>

                    <div id="content" class="column">
                    
                        <?if($BC->is_home_page()):?>
                            <?load_theme_view('inc/home-3')?>
                        <?else:?>
                            <?load_theme_view('inc/tpl-cur-location')?>
                        
                            <?load_theme_view($tpl_page)?>
                        <?endif?>
                        
                    </div><!-- /#content -->
                </div>
            </div><!-- /#main -->
        </div><!-- /#main-wrapper -->
    </div><!-- /#page -->

	<footer id="footer">
		<div class="section">
			<div class="region region-footer">
				<?load_theme_view('inc/bottom-nav')?>

				<div id="block-block-5">
					Євродах © 2011-<?=date('Y')?>
				</div><!-- /.block -->
			</div><!--{%FOOTER_LINK} -->
		</div><!-- /.section -->
	</footer><!-- /#footer -->
    <!-- /#page-wrapper -->
    
</body>
</html>
