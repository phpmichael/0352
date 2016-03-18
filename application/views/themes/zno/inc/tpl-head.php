<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?=$BC->_getPageTitle()?></title>
<meta name='description' content='<?=$head['meta_description']?>' />

<?load_theme_view('inc/meta-noindex')?>

<link rel="icon" href="<?=static_url()?>favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="<?=static_url()?>favicon.ico" type="image/x-icon" />

<?if(in_array($BC->_getController(),array('products','books')) && in_array($BC->_getMethod(),array('view','name'))):?>
<link rel="canonical" href="<?=site_url($BC->_getBaseURL().preg_replace('/s$/','',$BC->_getController()).'/'.$slug)?>" />
<?endif?>

<?=include_minified($BC->_getTheme().'css/bootstrap.css','css')?>

<?=include_minified($BC->_getTheme().'css/styles.css','css')?>

<!-- CSS -->
<?foreach ($BC->_getCSSFiles() as $css_file):?>
    <?=include_minified($css_file,'inline_css')?>
<?endforeach?>
<?=include_minified('css/dialog-cart.css','inline_css')?>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<script src="<?=static_url().$BC->_getFolder('js').'loaders/yepnope.min.js'?>"></script>

<script>
    yepnope({
        load: "http://code.jquery.com/jquery-1.11.0.min.js",
        complete: function () {
            $j = jQuery.noConflict();
            FaceBoxPath = "<?=base_url().$BC->_getFolder('js')?>jquery/facebox/";

            yepnope({
                load: ["<?=base_url().$BC->_getBaseURL().'app_js/config'?>",

                    <?if($BC->is_home_page()):?>
                    "<?=static_url().$BC->_getTheme().'js/jquery.cycle.all.min.js'?>",
                    "<?=static_url().$BC->_getTheme().'js/slider.minify.js'?>",
                    <?endif?>

                    <?if( in_array($BC->_getController(),array('products','books')) && in_array($BC->_getMethod(),array('view','name'))):?>
                    "<?=static_url().$BC->_getFolder('js').'jquery/lightbox/css/lightbox.minify.css'?>",
                    "<?=static_url().$BC->_getFolder('js').'jquery/lightbox/js/lightbox.minify.js'?>",
                    <?endif?>

                    "<?=static_url().$BC->_getFolder('js').'jquery/facebox/facebox.minify.css'?>",
                    "<?=static_url().$BC->_getFolder('js').'jquery/facebox/facebox.minify.js'?>",

                    "<?=static_url().$BC->_getFolder('js').'jquery/tipTipv13/tipTip.minify.css'?>",
                    "<?=static_url().$BC->_getFolder('js').'jquery/tipTipv13/jquery.tipTip.minify.js'?>"
                ],
                complete: function(){
                    <?=strip_tags(include_minified($BC->_getTheme().'js/categories-nav.js','inline_js'))?>

                    <?if(in_array($BC->_getController(),array('products','books')) && in_array($BC->_getMethod(),array('index','search')) && @$search_category_id):?>
                    $j(document).ready(function(){ open_level1_node($j("#products-categories a.active")); });
                    <?endif?>

                    <?if(in_array($BC->_getController(),array('products','books')) && in_array($BC->_getMethod(),array('search'))):?>
                    $j(document).ready(function(){
                        $j('select[name=sort_by]').change(function(){
                            location.href = search_url.replace('<?=$sort_by?>',this.value);
                        });
                        $j('.sort-direction').click(function(){
                            location.href = search_url.replace('<?=$sort_order?>',$j(this).attr('rel'));
                        });
                    });
                    <?endif?>

                    <?=strip_tags(include_minified($BC->_getFolder('js').'custom/cart/cart.js','inline_js'))?>
                    <?=strip_tags(include_minified($BC->_getFolder('js').'custom/cart/show_short_cart.js','inline_js'))?>
                    <?=strip_tags(load_inline_js('inc/js-add-to-cart'))?>

                    <?=strip_tags(include_minified($BC->_getTheme().'js/request-call.js','inline_js'))?>

                    <?if(in_array($BC->_getController(),array('contact_us'))):?>
                    <?=strip_tags(include_minified($BC->_getFolder('js').'custom/contact_us/send_form.js','inline_js'))?>
                    <?endif?>

                    <?=strip_tags(include_minified($BC->_getFolder('js').'jquery/facebox/init.js','inline_js'))?>

                    <?if(in_array($BC->_getController(),array('products','books')) && in_array($BC->_getMethod(),array('search')) ):?>
                    <?$BC->formbuilder_model->setJsIncluded()?>
                    <?=strip_tags(include_minified($BC->_getFolder('js').'custom/fb/process.js','inline_js'))?>
                    <?endif?>

                    <?foreach ($BC->_getJSFiles() as $js_file):?>
                    <?=strip_tags(include_minified($js_file,'inline_js'))?>
                    <?endforeach?>
                }
            });
        }
    });
</script>
