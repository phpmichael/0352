<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?=$BC->_getPageTitle()?></title>

<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet'>

<?=include_minified($BC->_getTheme().'css/bootstrap.css','css')?>

<?=include_minified($BC->_getTheme().'css/styles.css','css')?>

<!-- CSS -->
<?foreach ($BC->_getCSSFiles() as $css_file):?>
    <?=include_minified($css_file,'css')?>
<?endforeach?>
<?=include_minified('css/dialog-cart.css','inline_css')?>

<?=load_inline_js('inc/js-jquery')?>
<?//=load_inline_js('inc/js-qbaka'); ?>
<?=load_inline_js('inc/js-flash-msg')?>
<?=load_inline_js('inc/js-tooltip')?>

<?=include_js($BC->_getTheme().'js/bootstrap.min.js')?>

<?if( in_array($BC->_getController(),array('products','books')) && in_array($BC->_getMethod(),array('view','name'))):?>
    <?=load_inline_js('inc/js-lightbox')?>
<?endif?>

<?=load_inline_js('inc/js-facebox'); ?>

<?=include_minified($BC->_getFolder('js').'custom/cart/show_short_cart.js','inline_js')?>

<!-- Load Application Packages config -->
<script src="<?=base_url().$BC->_getBaseURL().'app_js/config'?>"></script>

<?foreach ($BC->_getJSFiles() as $js_file):?>
    <?=include_js($js_file)?>
<?endforeach?>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<?=include_minified($BC->_getTheme().'js/categories-nav.js','inline_js')?>

<?if(in_array($BC->_getController(),array('products','books')) && in_array($BC->_getMethod(),array('index','search')) && @$search_category_id):?>
    <script>
        $j(document).ready(function(){ open_level1_node($j("#products-categories a.active")); });
    </script>
<?endif?>

<!-- Slider -->
<?=include_js($BC->_getTheme().'js/jquery.cycle.all.min.js')?>
<?=include_minified($BC->_getTheme().'js/slider.js','inline_js')?>