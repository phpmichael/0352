<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">

<title><?=$head['site_title']?><?if($head['page_title']):?> :: <?=$head['page_title']?><?endif?></title>
<meta name='description' content='<?=$head['meta_description']?>' />
<meta name='keywords' content='<?=$head['meta_keywords']?>' />

<meta name="robots" content="INDEX,FOLLOW" />

<!-- RSS --> 
<link type="application/rss+xml" href="<?=site_url($BC->_getBaseURL().'articles/RSS') ?>" title="Articles RSS Feed" rel="alternate" />

<?=include_combined(array($BC->_getTheme().'css/reset.css',$BC->_getTheme().'css/layout.css',$BC->_getTheme().'css/style.css'),$BC->_getTheme().'css/combined.css','css')?>

<?$this->load->view('inc/js-jquery')?>
<?=include_minified($BC->_getTheme().'js/bgstretcher.js','js')?>
<script>

    jQuery(document).ready(function(){
      //  Initialize Backgound Stretcher
       jQuery(document).bgStretcher({
        images: ['<?=$BC->_getTheme()?>images/wrapper_site.gif'], imageWidth: 1395, imageHeight: 1500
       });
    });

</script>

<?=include_minified($BC->_getTheme().'js/cufon-yui.js','js')?>
<?=include_minified($BC->_getTheme().'js/cufon-replace.js','js')?>
<?=include_minified($BC->_getTheme().'js/Lane_-_Narrow_400.font.js','js')?>

<?=include_minified($BC->_getTheme().'js/loopedslider.0.5.4.js','js')?>
<script>

	jQuery(function(){
		jQuery('#loopedSlider').loopedSlider({
			autoStart: 11500
		});
	});

</script>

<?=include_minified($BC->_getTheme().'js/imagepreloader.js','inline_js')?>

<!--[if lt IE 9]>
<?=include_js($BC->_getTheme().'js/html5.js')?>
<![endif]-->
<!--[if IE 6]><script src="http://info.template-help.com/files/ie6_warning/ie6_script_other.js"></script><![endif]-->
</head>

<body id="page1">
<div class="main" id="main">
	<div class="wrapper-top clear"><span><span></span></span></div>
    <div class="wrapper-left clear">
    	<div class="wrapper-right">
        	<div class="wrapper-indent">
            	<div class="wrapper clear">
                	<!--==============================header=================================-->
                        <header>
                            <div class="header clear">
                                <a href="#" class="logo"><img src="<?=$BC->_getTheme()?>images/logo.gif" alt="" /></a>
                                <a href="#" class="link-twitter"><img  src="<?=$BC->_getTheme()?>images/header_img.jpg"  alt=""  /></a>
                            </div>
                            <div class="row-menu">
                            	<div class="wrapper-menu-box clear">
                                	<div class="fright">
                                    	<form id="FormHeader" action="">
                                           <div class="box-search">
                                                <input type="text" value="" class="input"  />
                                                <a href="#" class="link" onClick="document.getElementById('FormHeader').submit()"></a>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="fleft">
                                    	<nav>
                                            <ul class="top-menu">
                                                <li><a href="#" class="active">home</a></li>
                                                <li><a href="#">about us</a></li>
                                                <li><a href="#">articles</a></li>
                                                <li><a href="#">our news</a></li>
                                                <li><a href="#">health care</a></li>
                                                <li class="bg-none"><a href="#">contacts</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
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
                                                   <img src="<?=$BC->_getTheme()?>images/slide1.jpg" alt="" />
                                                </div>
                                                <div>
                                                	<dl class="slider-text">
                                                    	<dt>Fusce euismod<br  /> consectetuer ?</dt>
                                                        <dd>
                                                        	Moleie lacneanrit maellus prases etajertas  ertya derase krtasertasera esedaser asdusce lertswer lrurtasfeugiat malesua. 
                                                            <p><a href="#">Read More</a></p>
                                                        </dd>
                                                    </dl>
                                                	<img src="<?=$BC->_getTheme()?>images/slide2.jpg" alt="" />
                                                </div>
                                                <div>
                                                	<dl class="slider-text">
                                                    	<dt>Esedaser <br  /> krtasertasera?</dt>
                                                        <dd>
                                                        	Moleie lacneanrit maellus prases etajertas  ertya derase krtasertasera esedaser asdusce lertswer lrurtasfeugiat malesua. 
                                                            <p><a href="#">Read More</a></p>
                                                        </dd>
                                                    </dl>
                                                    <img src="<?=$BC->_getTheme()?>images/slide3.jpg" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                        <a href="#" class="previous">previous</a>
                                        <a href="#" class="next">next</a>
                                        <ul class="pagination">
                                            <li><a href="#"><img  src="<?=$BC->_getTheme()?>images/slider_button1.png" alt=""  /></a></li>
                                            <li><a href="#"><img  src="<?=$BC->_getTheme()?>images/slider_button2.png" alt=""  /></a></li>
                                            <li><a href="#"><img  src="<?=$BC->_getTheme()?>images/slider_button3.png" alt=""  /></a></li>
                                        </ul>	
                                    </div>
                                </div>
                            </div>
                        </header>
                        <!--==============================content================================-->
                      <section id="content">
                            <article>
                              <div class="clear">
                                 <div class="col-1">
                                 	<div class="box-1 clear">
                                    	<div class="box-1-indent">
                                        	<div class="clear">
                                            	<h3 title="Welcome!"><img  src="<?=$BC->_getTheme()?>images/title1.png" alt=""  /></h3>
                                                <span class="text">Dolerloaser hrese leosera  asumales utases adipiscing  aliasuam lemiolor.</span>
                                                <p class="indent-top">Nulla duiuscat malesuada odioravida atcursusec  luctus a lorem. Maecenas triue orcseuilt pharetra  magnonec accumsauada orci. </p>
                                                <a href="#" class="button1 button1-indent"><span><span>Read More</span></span></a>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="col-2">
                                 	<h3>News & Events</h3>
                                    <div class="clear img-bottom"><img  src="<?=$BC->_getTheme()?>images/page1_img1.jpg" alt=""  /></div>
                                    <strong class="br text-1">20.Jan.2011 Shower Games</strong>
                                    eliasraent vestibul uoleadi piscing lacusenean ummy hendrerit mauris  scvarius elportasce sude.
                                    <a href="#" class="button button1-indent"><span><span>Read More</span></span></a>
                                 </div>
                                 <div class="col-3">
                                 	<div class="box-2 clear">
                                    	<div class="box-2-indent">
                                        	<div class="clear">
                                            	<h3 class="title-bottom">Hot Topics</h3>
                                                <ul>
                                                	<li><a href="#">Baby Names</a></li>
                                                    <li><a href="#">Labor & Delivery</a></li>
                                                    <li><a href="#">Baby Showers</a></li>
                                                    <li><a href="#">Pregnancy signs & Symptoms</a></li>
                                                    <li><a href="#">Fertility</a></li>
                                                    <li><a href="#">Due Date Tools</a></li>
                                                    <li><a href="#">Ovulation</a></li>
                                                    <li><a href="#">Gear</a></li>
                                                    <li><a href="#">Diaper Bags</a></li>
                                                    <li><a href="#">Infant Clothing Basics</a></li>
                                                    <li><a href="#">Feeding & Nursing</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                              </div>
                              
                            </article>  
                      </section>
                     <section>
                            <article>
                              <div class="content-bottom clear">
                                <div class="content-bottom-indent">
                                    <div class="clear content-bottom-text">
                                        <div class="col-1">
                                            <div class="clear">
                                                <img  src="<?=$BC->_getTheme()?>images/page1_img2.png" class="img-indent" alt=""  />
                                                <p class="text11">Top 100 baby names </p>
                                                elitauris fermyas ctulaore vasaliam lemiolor.
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <img  src="<?=$BC->_getTheme()?>images/page1_img3.png" class="img-indent" alt=""  />
                                                <p class="text11">Detecting Ovulation </p>
                                                neanauctor wisi et urnase vasum erat volutpat.
                                        </div>
                                    </div>
                                </div>
                              </div>
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
                            <span class="text">NewLife  © 2010  | <a href="#">Privacy policy</a></span> 
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