<meta charset="utf-8" />

<title><?=strip_tags($head['site_title'])?> :: <?=$BC->_getPageTitle()?></title>
<meta name='description' content='<?=addslashes($head['meta_description'])?>' />
<meta name='keywords' content='<?=addslashes($head['meta_keywords'])?>' />

<link href='https://fonts.googleapis.com/css?family=Marck+Script&subset=cyrillic' rel='stylesheet' type='text/css'>

<?=include_combined(array($BC->_getTheme().'css/zero.css', $BC->_getTheme().'css/style.css', $BC->_getTheme().'css/gallery.css'),$BC->_getTheme().'css/styles.css','css')?>

<!--Load JS-->
<?=load_inline_js('inc/js-jquery')?>
<?=include_js($BC->_getBaseURL().'app_js/config')?>
<!--Load JS-->