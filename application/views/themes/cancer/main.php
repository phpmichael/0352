<?
//$BC->load->helper('customer');
$BC->load->helper('blog');
//$BC->load->helper('poll');
//$BC->load->helper('social');
?>
<!DOCTYPE html>
<html lang="en">
<head>

<base href="http://localhost/CI/cancer/" />

<meta charset="utf-8">

<title><?=$head['site_title']?><?if($head['page_title']):?> :: <?=$head['page_title']?><?endif?></title>
<meta name='description' content='<?=$head['meta_description']?>' />
<meta name='keywords' content='<?=$head['meta_keywords']?>' />

<meta name="robots" content="INDEX,FOLLOW" />

<!-- RSS --> 
<link type="application/rss+xml" href="<?=site_url($BC->_getBaseURL().'articles/RSS') ?>" title="Articles RSS Feed" rel="alternate" />

<?=include_combined(array($BC->_getTheme().'css/reset.css',$BC->_getTheme().'css/layout.css',$BC->_getTheme().'css/style.css'),$BC->_getTheme().'css/combined.css','css')?>
<?foreach ($BC->_getCSSFiles() as $css_file):?>
<?=include_minified($css_file,'inline_css')?>
<?endforeach?>

<?$this->load->view('inc/js-jquery')?>
<?=include_minified($BC->_getTheme().'js/bgstretcher.js','js')?>
<script>
//<![CDATA[
    jQuery(document).ready(function(){
      //  Initialize Backgound Stretcher
       jQuery(document).bgStretcher({
        images: ['<?=base_url().$BC->_getTheme()?>images/wrapper_site.gif'], imageWidth: 1395, imageHeight: 1500
       });
    });
//]]>
</script>

<?=include_minified($BC->_getTheme().'js/cufon-yui.js','js')?>
<?=include_minified($BC->_getTheme().'js/cufon-replace.js','js')?>
<?=include_minified($BC->_getTheme().'js/Lane_-_Narrow_400.font.js','js')?>

<?=include_minified($BC->_getTheme().'js/loopedslider.0.5.4.js','js')?>
<script>
//<![CDATA[
	jQuery(function(){
		jQuery('#loopedSlider').loopedSlider({
			autoStart: 11500
		});
	});
//]]>
</script>

<?=include_minified($BC->_getTheme().'js/imagepreloader.js','inline_js')?>

<!--[if lt IE 9]>
<?=include_js($BC->_getTheme().'js/html5.js')?>
<![endif]-->
<!--[if IE 6]><script src="http://info.template-help.com/files/ie6_warning/ie6_script_other.js"></script><![endif]-->

<!-- Load Application Packeges config -->
<?=include_js($BC->_getBaseURL().'app_js/config')?>

<?foreach ($BC->_getJSFiles() as $js_file):?>
<?=inline_js($js_file)?>
<?endforeach?>

</head>

<body id="page2">
<div class="main" id="main">
	<div class="wrapper-top clear"><span><span></span></span></div>
    <div class="wrapper-left clear">
    	<div class="wrapper-right">
        	<div class="wrapper-indent">
            	<div class="wrapper clear">
                	<!--==============================header=================================-->
                        <header>
                            <div class="header clear">
                                <a href="#" class="logo"><img src="<?=base_url().$BC->_getTheme()?>images/logo.gif" alt="" /></a>
                                <a href="#" class="link-twitter"><img  src="<?=base_url().$BC->_getTheme()?>images/header_img.jpg"  alt=""  /></a>
                            </div>
                            <div class="row-menu">
                            	<div class="wrapper-menu-box clear">
                                	<div class="fright">
                                    	<form id="FormHeader" action="<?=site_url($BC->_getBaseURL().'articles')?>">
                                           <div class="box-search">
                                                <input name="keywords" type="text" value="<?=@$keywords?>" class="input" onclick="this.select()"  />
                                                <a href="javascript:;" class="link" onclick="document.getElementById('FormHeader').submit()"></a>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="fleft">
                                    	<nav>
                                            <ul class="top-menu">
                                                <?=get_menu('left')?>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <!--
                            <div class="row-slider">
                            	<div class="clear slider-bg">
                                	<div id="loopedSlider">	
                                        <div class="container">
                                            <div class="slides">
                                                <div>
                                                	<dl class="slider-text">
                                                    	<dt>First Time<br  /> Pregnancy?</dt>
                                                        <dd>
                                                        	Moleie lacneanrit maellus prases etajertas  ertya derase krtasertasera esedaser asdusce lertswer lrurtasfeugiat malesua. 
                                                            <p><a href="#">Read More</a></p>
                                                        </dd>
                                                    </dl>
                                                   <img src="<?=base_url().$BC->_getTheme()?>images/slide1.jpg" alt="" />
                                                </div>
                                                <div>
                                                	<dl class="slider-text">
                                                    	<dt>Fusce euismod<br  /> consectetuer ?</dt>
                                                        <dd>
                                                        	Moleie lacneanrit maellus prases etajertas  ertya derase krtasertasera esedaser asdusce lertswer lrurtasfeugiat malesua. 
                                                            <p><a href="#">Read More</a></p>
                                                        </dd>
                                                    </dl>
                                                	<img src="<?=base_url().$BC->_getTheme()?>images/slide2.jpg" alt="" />
                                                </div>
                                                <div>
                                                	<dl class="slider-text">
                                                    	<dt>Esedaser <br  /> krtasertasera?</dt>
                                                        <dd>
                                                        	Moleie lacneanrit maellus prases etajertas  ertya derase krtasertasera esedaser asdusce lertswer lrurtasfeugiat malesua. 
                                                            <p><a href="#">Read More</a></p>
                                                        </dd>
                                                    </dl>
                                                    <img src="<?=base_url().$BC->_getTheme()?>images/slide3.jpg" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                        <a href="#" class="previous">previous</a>
                                        <a href="#" class="next">next</a>
                                        <ul class="pagination">
                                            <li><a href="#"><img  src="<?=base_url().$BC->_getTheme()?>images/slider_button1.png" alt=""  /></a></li>
                                            <li><a href="#"><img  src="<?=base_url().$BC->_getTheme()?>images/slider_button2.png" alt=""  /></a></li>
                                            <li><a href="#"><img  src="<?=base_url().$BC->_getTheme()?>images/slider_button3.png" alt=""  /></a></li>
                                        </ul>	
                                    </div>
                                </div>
                            </div>
                            -->
                        </header>
                        <!--==============================content================================-->
                      <section id="content">
                            <article>
                              
                              <div class="clear">
                              
                                 
                                 <div class="col-1">
                                 	<div class="box-1 clear">
                                    	<div class="box-1-indent">
                                        	<div class="clear">
                                            	 <?load_theme_view($tpl_page)?>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 
                                 <div class="col-2">
                                 	<div class="box-2 clear">
                                    	<div class="box-2-indent">
                                        	<div class="clear">
                                            	<h3 class="title-bottom">All Categories</h3>
                                                <?=get_categories_tree('articles',0,@$search_category_id,array('root_id'=>'articles-categories'));?>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                              </div>
                              
                            </article>  
                      </section>
                     <section>
                            <article>
                              <!--
                              <div class="content-bottom clear">
                                <div class="content-bottom-indent">
                                    <div class="clear content-bottom-text">
                                        <div class="col-1">
                                            <div class="clear">
                                                <img  src="<?=base_url().$BC->_getTheme()?>images/page1_img2.png" class="img-indent" alt=""  />
                                                <p class="text11">Top 100 baby names </p>
                                                elitauris fermyas ctulaore vasaliam lemiolor.
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <img  src="<?=base_url().$BC->_getTheme()?>images/page1_img3.png" class="img-indent" alt=""  />
                                                <p class="text11">Detecting Ovulation </p>
                                                neanauctor wisi et urnase vasum erat volutpat.
                                        </div>
                                    </div>
                                </div>
                              </div>
                              -->
                              <div class="content-bottom1 clear">
                                <div class="content-bottom1-indent">
                                    <div class="clear">
                                        <div class="col-1">
                                            <div class="clear">
                                                <div class="row-list clear">
                                                    <ul>
                                                       <li><a href="#">Our Staff</a></li>
                                                       <li><a href="#">Did you know?</a></li>
                                                       <li><a href="#">Our Articles</a></li>
                                                    </ul>
                                                    <ul class="list-indent">
                                                        <li><a href="#">On-line Consultation</a></li>
                                                        <li><a href="#">FAQs</a></li>
                                                    </ul>
                                                    <ul class="list-indent">
                                                    	<li><a href="#">Special Solutions</a></li>
                                                        <li><a href="#">Hot News</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 separator">
                                         	<div class="separator-top">
                                            	<div class="indent-col">
                                                    <div class="clear">
                                                        <h3>Newsletter Sign Up</h3>
                                                        <form id="FormFooter" action="">
                                                           <div class="box-search clear">
                                                                <input type="text" value="Enter your E-mail" onBlur="if(this.value=='') this.value='Enter your E-mail'" onFocus="if(this.value =='Enter your E-mail' ) this.value=''"  class="input"  />
                                                                <a href="#" class="link" onClick="document.getElementById('FormFooter').submit()">Subscribe</a>
                                                            </div>
                                                            <span class="text-form">unsubscribe <a href="#">here</a></span>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              </div>
                     	 </article>  
                      </section>
                    <!--==============================footer=================================-->
                  <footer>
                        <div class="footer clear">
                            <span class="text">NewLife  © 2012  | <a href="#">Privacy policy</a></span> 
                    	    <!-- {%FOOTER_LINK} -->     
                        </div>
                  </footer>
                </div>
            </div>
        </div>
    </div>
  <div class="wrapepr-bottom clear"><span><span></span></span></div>
</div>
<script> Cufon.now(); </script>

</body>
</html>