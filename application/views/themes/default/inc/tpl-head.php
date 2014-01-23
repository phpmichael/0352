<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv='expires' content='-1' />
<meta http-equiv='pragma' content='no-cache' />
<meta name='robots' content='all' />

<title><?=$head['site_title']?><?if($head['page_title']):?> :: <?=$head['page_title']?><?endif?></title>
<meta name='description' content='<?=$head['meta_description']?>' />
<meta name='keywords' content='<?=$head['meta_keywords']?>' />

<!-- CSS Styles -->
<?=include_css('css/zero.css')?>
<?=include_css($BC->_getTheme().'css/styles.css')?>
<?foreach ($BC->_getCSSFiles() as $css_file):?>
<?=include_css($css_file)?>
<?endforeach?>

<!-- RSS --> 
<link type="application/rss+xml" href="<?=site_url($BC->_getBaseURL().'news/RSS') ?>" title="News RSS Feed" rel="alternate" />
<link type="application/rss+xml" href="<?=site_url($BC->_getBaseURL().'articles/RSS') ?>" title="Articles RSS Feed" rel="alternate" />

<!--Load JS-->
<?=load_inline_js('inc/js-jquery'); ?>
<?=load_inline_js('inc/js-custom-functions'); ?>
<!--Load JS-->

<?=load_inline_js('inc/js-IE-fix')?>

<!-- Load Application Packeges config -->
<?=include_js($BC->_getBaseURL().'app_js/config')?>

<?foreach ($BC->_getJSFiles() as $js_file):?>
<?=include_js($js_file)?>
<?endforeach?>
