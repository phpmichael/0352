<?
$BC->load->helper('customer');
$BC->load->helper('blog');
//$BC->load->helper('poll');
$BC->load->helper('social');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title><?=$head['site_title']?></title>
        
        <link rel="stylesheet" href="https://ajax.aspnetcdn.com/ajax/jquery.mobile/1.1.1/jquery.mobile.structure-1.1.1.min.css" />
        <?=include_minified($BC->_getTheme().'css/m.dark1.css','css')?>
        
        <?=include_minified($BC->_getTheme().'css/styles.css','css')?>
        
        <?foreach ($BC->_getCSSFiles() as $css_file):?>
		<?=include_minified($css_file,'inline_css')?>
		<?endforeach?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.mobile/1.1.1/jquery.mobile-1.1.1.min.js"></script>
        <?=include_minified($BC->_getTheme().'js/my.js','js')?>
        
        <script>$j = jQuery.noConflict();</script>
        
        <!-- Load Application Packeges config -->
		<?=include_js($BC->_getBaseURL().'app_js/config')?>
		
		<?foreach ($BC->_getJSFiles() as $js_file):?>
		<?=inline_js($js_file)?>
		<?endforeach?>
    </head>
    <body>
        <!-- Home -->
        <div data-role="page" id="page1">
            <div data-theme="a" data-role="header" id="header">
            	<a data-role="button" data-transition="fade" href="<?=base_url().$BC->_getBaseURL()?>" data-icon="home" data-iconpos="top" class="ui-btn-left" id="home-btn"></a>
                <span class="ui-title">ЕКОМАГ</span>
            </div>
            <div data-role="content" style="padding: 15px">
            	
            	<?if($BC->is_home_page()):?>
	            	<?//load_theme_view('inc/box-jcarousel')?>
	            	<?load_theme_view('inc/home')?>
	            <?else:?>
					<?load_theme_view($tpl_page)?>
	            <?endif?>
            </div>
            <div data-theme="a" data-role="footer" data-position="fixed" id="footer">
            	<?=get_menu('bottom','separator')?>
                <h5>
                    &copy; 2010-<?=date('Y')?> EKOMAG
                </h5>
            </div>
        </div>
        <script>
            $j(document).bind("mobileinit", function(){
			    $j.mobile.ajaxEnabled = false;
			});
        </script>
    </body>
</html>