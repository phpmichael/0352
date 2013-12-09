<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title><?=$head['site_title']?><?if($head['page_title']):?> :: <?=$head['page_title']?><?endif?></title>
<meta name='description' content='<?=$head['meta_description']?>' />
<meta name='keywords' content='<?=$head['meta_keywords']?>' />

<meta name="robots" content="INDEX,FOLLOW" />

<!-- RSS --> 
<link type="application/rss+xml" href="<?=site_url($BC->_getBaseURL().'articles/RSS') ?>" title="Articles RSS Feed" rel="alternate" />

<!--[if lt IE 7]>
<script type="text/javascript">
//<![CDATA[
    var BLANK_URL = '<?=(base_url().$BC->_getTheme().'js/blank.html') ?>';
    var BLANK_IMG = '<?=(base_url().$BC->_getTheme().'js/spacer.gif') ?>';
//]]>
</script>
<![endif]-->

<!-- CSS -->
<?=include_combined( array($BC->_getTheme().'css/styles.css', $BC->_getTheme().'css/poll.css'), $BC->_getTheme().'css/combined.css', 'css')?>
<?=include_css($BC->_getTheme().'css/print.css','print')?>
<?foreach ($BC->_getCSSFiles() as $css_file):?>
<?=include_css($css_file)?>
<?endforeach?>

<!-- Prototype JS -->
<?=include_combined( array($BC->_getTheme().'js/prototype.js', $BC->_getTheme().'js/menu.js'), $BC->_getTheme().'js/combined_menu.js', 'js')?>
<!--[if lt IE 8]>
<?=include_css($BC->_getTheme().'css/styles-ie.css')?>
<![endif]--> 
<!--[if lt IE 7]>
<?=include_js($BC->_getTheme().'js/ds-sleight.js')?>
<?=include_js($BC->_getTheme().'js/ie6.js')?>
<![endif]--> 

<?=include_js($BC->_getTheme().'js/imagepreloader.js')?>
<script type="text/javascript">
	preloadImages([		
		'<?=(base_url().$BC->_getTheme())?>images/menu_button_active_bg.jpg'
		]);
</script>

<!--Load JS-->
<?$this->load->view('inc/js-jquery'); ?>
<?$this->load->view('inc/js-custom-functions'); ?>
<!--Load JS-->

<!-- Load Application Packeges config -->
<?=include_js($BC->_getBaseURL().'app_js/config')?>

<?foreach ($BC->_getJSFiles() as $js_file):?>
<?=include_js($js_file)?>
<?endforeach?>

