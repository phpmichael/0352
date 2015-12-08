<meta charset="utf-8" />

<title><?if($head['page_title']):?><?=$head['page_title']?> - <?endif?> <?=$head['site_title']?></title>
<meta name='description' content='<?=$head['meta_description']?>' />
<meta name='keywords' content='<?=$head['meta_keywords']?>' />

<!-- RSS --> 
<link type="application/rss+xml" href="<?=site_url($BC->_getBaseURL().'articles/RSS') ?>" title="Articles RSS Feed" rel="alternate" />

<!-- favicon -->
<link type="image/x-icon" href="<?=base_url().$BC->_getTheme()?>images/favicon.ico" rel="icon" />

<!-- Prevent blocking -->
<meta name="viewport" content="width=device-width, initial-scale=1.0" />


<!--[if lt IE 9]><?=include_minified($BC->_getTheme().'js/html5.js','js')?><![endif]-->

<!--[if lt IE 7]>
<div style=' clear: both; text-align:center; position: relative;'>
    <a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://www.theie6countdown.com/images/upgrade.jpg" border="0"  alt="" /></a>
</div>
<![endif]-->

<!--[if gte IE 8]>
 <style>
    #superfish-1 a, #superfish-1 a:visited { padding:20px 18px 19px;}
</style>
<![endif]-->

<?=include_css($BC->_getTheme().'css/main.css?v=2014-03-31')?>

<?=include_minified($BC->_getTheme().'css/poll.css','inline_css')?>

<?foreach ($BC->_getCSSFiles() as $css_file):?>
<?=include_minified($css_file,'css')?>
<?endforeach?>

<?=load_inline_js('inc/js-jquery')?>
<?=load_inline_js('inc/js-jquery-ui')?>

<?//=include_js($BC->_getTheme().'js/jquery.once.js')?>
<?//=include_js($BC->_getTheme().'js/drupal.js')?>
<?=include_js($BC->_getTheme().'js/jquery.hoverintent.minified.js')?>
<?=include_minified($BC->_getTheme().'js/jquery.bgiframe.js','js')?>

<!-- Scripts for menu -->
<?//=include_js($BC->_getTheme().'js/superfish.js')?>
<?//=include_js($BC->_getTheme().'js/supersubs.js')?>
<?//=include_js($BC->_getTheme().'js/supposition.js')?>
<?//=include_js($BC->_getTheme().'js/sftouchscreen.js')?>

<?=include_minified($BC->_getTheme().'js/jquery.cycle.all.js','js')?>

<script>
    /*jQuery(function(){
        jQuery('#superfish-1').supersubs({minWidth: 12, maxWidth: 27, extraWidth: 1}).superfish(
        {
            animation: {opacity:'show'},
            speed: 'fast',
            autoArrows: false,
            dropShadows: true
        });
    });*/
</script>

<?//=include_js($BC->_getTheme().'js/jquery.ui.dialog.patch.js')?>
<script>
$j('#partner-slider').cycle({
	fx: 'fade'
});
</script>

<!-- Load Application Packeges config -->
<?=include_js($BC->_getBaseURL().'app_js/config')?>

<?foreach ($BC->_getJSFiles() as $js_file):?>
<?=include_js($js_file)?>
<?endforeach?>


<script>
<!--//--><![CDATA[//><!--
$j(document).ready(function() {
    $j('#slider').after('<div id="slider-nav" class="views-jqfx-controls-bottom">').cycle({
		fx: 'fade',
		pager: '#slider-nav' ,
		activePagerClass: 'active-slide',
		pagerAnchorBuilder: function(idx, slide) {
			var page_id = parseInt(idx)+1;
	        return '<div class="pager-item pager-num-'+page_id+'"><a href="#">'+page_id+'</a></div>'; 
	    } 
	});
});
//--><!]]>
</script>

<?if($BC->_getController()=='assortment' && in_array($BC->_getMethod(),array('view','name'))):?>
<?=load_inline_js('inc/js-lightbox')?>
<?endif?>