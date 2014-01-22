<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>
    <?if($BC->_getController()=='products' && in_array($BC->_getMethod(),array('view','name')) && @$page_title):?>
        <?=$page_title?>
    <?elseif(!$BC->is_home_page() && $head['page_title']):?>
        <?=$head['page_title']?>
    <?else:?>
        <?=$head['site_title']?>
    <?endif?>
</title>
<meta name='description' content='<?=$head['meta_description']?>' />
<meta name='keywords' content='<?=$head['meta_keywords']?>' />

<meta name="robots" content="INDEX,FOLLOW" />

<!-- RSS --> 
<link type="application/rss+xml" href="<?=site_url($BC->_getBaseURL().'articles/RSS') ?>" title="Articles RSS Feed" rel="alternate" />

<!-- favicon -->
<link type="image/x-icon" href="<?=base_url().$BC->_getTheme()?>images/favicon.ico" rel="icon" />

<!-- CSS -->
<?=include_combined( array($BC->_getTheme().'css/constant.css', $BC->_getTheme().'css/template.css', $BC->_getTheme().'css/shop.css', $BC->_getTheme().'css/custom.css', $BC->_getTheme().'css/poll.css'), $BC->_getTheme().'css/combined.css', 'css')?>
<?=include_minified($BC->_getTheme().'css/print.css','css','print')?>
<?foreach ($BC->_getCSSFiles() as $css_file):?>
<?=include_minified($css_file,'css')?>
<?endforeach?>
<?=include_minified('css/dialog-cart.css','css')?>

<!-- Load JS -->
<?$this->load->view('inc/js-jquery')?>
<?$this->load->view('inc/js-jquery-ui')?>
<?$this->load->view('inc/js-custom-functions')?>
<?$this->load->view('inc/js-tooltip')?>

<?if($BC->_getController()=='products' && in_array($BC->_getMethod(),array('view','name'))):?>
<?$this->load->view('inc/js-lightbox')?>
<?endif?>

<?=include_minified($BC->_getTheme().'js/imagepreloader.js','js')?>
<script>var base_url = '<?=base_url()?>';</script>
<?=include_minified($BC->_getTheme().'js/ddsmoothmenu.js','js')?>

<!-- Load Application Packeges config -->
<?=include_js($BC->_getBaseURL().'app_js/config')?>

<?foreach ($BC->_getJSFiles() as $js_file):?>
<?=include_js($js_file)?>
<?endforeach?>

<?=include_js($BC->_getFolder('js').'custom/request_call/send_form.js')?>

<script>

    preloadImages([
        '<?=base_url().$BC->_getTheme()?>images/button-bg-hover.png',
        '<?=base_url().$BC->_getTheme()?>images/search-button-active.gif',
        '<?=base_url().$BC->_getTheme()?>images/top-menu-a-active.png'
    ]);

</script>

<?php $this->load->view('inc/js-facebox'); ?>
