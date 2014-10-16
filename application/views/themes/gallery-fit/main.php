<?
//get photos list
$photos_model = load_model('photos_model');
$photosData = $photos_model->get(0,0,999);
$photos = $photosData['list'];
$photos_per_page = 10;
$photos_pages_count = ceil(count($photos)/$photos_per_page);


//get pages data
$pages['contacts'] = $BC->pages_model->getByLink('contact_us');
$pages['about'] = $BC->pages_model->getByLink('about');
$pages['about_makeup'] = $BC->pages_model->getBySlug('pro-makiyazh');

//get captcha image
$captcha_model = load_model('captcha_model');
$cap_img = $captcha_model->make();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    
    <title><?=$head['site_title']?></title>
    
    <?=include_minified($BC->_getTheme().'css/style.css','css')?>
    
    <?=include_minified($BC->_getTheme().'js/jquery-1.4.3.min.js','js')?>
    <?//=include_minified($BC->_getTheme().'js/bgSlider.js','js')?>
    <?//=include_minified($BC->_getTheme().'js/jquery.mousewheel.js','js')?>
    <?//=include_minified($BC->_getTheme().'js/jScrollPane.js','js')?>
    <?//=include_minified($BC->_getTheme().'js/slidePager.js','js')?>
    <?=include_combined(array(
                                //$BC->_getTheme().'js/jquery-1.4.3.min.js',
                                $BC->_getTheme().'js/bgSlider.js',
                                $BC->_getTheme().'js/jquery.mousewheel.minify.js',
                                $BC->_getTheme().'js/jScrollPane.minify.js',
                                $BC->_getTheme().'js/slidePager.js'
                                ),
                        $BC->_getTheme().'js/combined.js','js')?>
       
    <!--[if lt IE 7]>
    <?=include_minified($BC->_getTheme().'js/ie6_script_other.js','js')?>
    <![endif]-->
    <!--[if lt IE 9]>
    <?=include_minified($BC->_getTheme().'js/html5.js','js')?>
    <?=include_minified($BC->_getTheme().'js/multiplyBG.js','js')?>
    <![endif]-->
    <!--[if IE]>
    <?=include_minified($BC->_getTheme().'css/ie_style.css','css')?>
    <![endif]-->
    
</head>

<body>

    <div class="glob">

        <a class="gall_prev"></a>
        <a class="gall_next"></a>

        <aside>
            <nav>
                <ul>
                    <li class="active"><a href="#page1" rel="slide">Галерея</a></li>
                    <li><a href="#page2" rel="slide"><?=$pages['about']['page_title']?></a></li>
                    <li><a href="#page3" rel="slide"><?=$pages['contacts']['page_title']?></a></li>
                </ul>
            </nav>
            <div class="pages">
                <div class="page" id="page1">
                    <a class="button-method button">
                        <span class="wrap">image view mode</span>
                        <span class="meth">fit</span>
                    </a>

                    <?for ($page_num=1;$page_num<=$photos_pages_count;$page_num++):?>
                        <a href="javascript:;" class="paginator<?if($page_num===1):?> active<?endif?>" rel="<?=$page_num?>"><?=$page_num?></a>
                    <?endfor;?>

                    <div class="scroll">
                        <ul id="thumbs">

                        </ul>
                    </div>
                </div>
                <div class="page" id="page2">
                    <div class="scroll">
                        <img src="<?=$BC->_getTheme()?>images/maria-kovalska.jpg" width="510" height="376" class="p2" alt="Maria Kovalska">
                        <?=$pages['about']['body']?>
                    </div>
                </div>
                <div class="page" id="page3">
                    <div class="scroll">
                        <?=$pages['contacts']['body']?>

                        <p class="required">* <?=language('required_fields')?></p>
                        <div class="green" id="success"></div>
                        <div class="red" id="errors"></div>

                        <form id="contact_form" action="#" method="post">
                            <input type="submit" style="display:none" />
                            <label><?=language('name')?>:
                                <input type="text" name="name">
                            </label>
                            <label><?=language('email')?>:
                                <input type="text" name="email">
                            </label>
                            <label><?=language('message')?>:
                                <textarea name="message"></textarea>
                            </label>
                            <?=$cap_img?>
                            <label><?=language('captcha')?>:
                                <input type="text" name="captcha">
                            </label>
                            <div class="btns und">
                                <a href="javascript:void(0)" onclick="$j('#contact_form :input[type=submit]').click()"><?=language('submit')?></a>
                            </div>
                            <div>&nbsp;<br />&nbsp;<br />&nbsp;<br />&nbsp;</div>
                        </form>

                    </div>
                </div>
                <div class="page" id="page4">
                    <div class="scroll">
                        <?=$pages['about_makeup']['body']?>

                        <p><?=$BC->settings_model['site_partners']?></p>
                    </div>
                </div>
            </div>
        </aside>
        <footer>
            <h1>
                <a href="<?=base_url()?>">Maria Kovalska</a>
                <span class="slogan">The art of <span class="white">make-up</span></span>
            </h1>
            <div class="privacy">
                Maria Kovalska &copy; 2012
                <a href="#page4" rel="slide" class="white und">
                    <?=$pages['about_makeup']['page_title']?>
                </a>
                <br />
                <!-- {%FOOTER_LINK} -->
            </div>
        </footer>

    </div>

    <!-- Load Application Packeges config -->
    <?=include_js($BC->_getBaseURL().'app_js/config')?>

    <script>
        var slidesArr = [];
        <?$i=-1; foreach ($photos as $record): $i++;?>
        slidesArr[<?=$i?>] = '<?=relative_url().('images/data/b/photos/'.$record['file_name'])?>';
        <?endforeach?>
    </script>

    <?=include_minified($BC->_getTheme().'js/main.js','js')?>

    <script>
        var photos = [];

        <?$i=0;foreach ($photos as $record):$i++;?>
        photos[<?=$i?>] = '<?=$record['file_name']?>';
        <?endforeach?>

        function show_photos(pageNum,perPage)
        {
            var i = (pageNum-1)*perPage+1;
            var lastPhoto = i+perPage;

            $j("#thumbs").empty().hide();

            while(i<lastPhoto)
            {
                if(i>=photos.length) break;

                $j("#thumbs").append("<li><a href='javascript:;' rel='"+i+"'><img src='<?=base_url().'images/data/s/photos/'?>"+photos[i]+"' width='230' height='162' alt='' /></a></li>");
                i++;
            }
            $j("#thumbs").fadeIn(1000);
        }

        show_photos(1,<?=$photos_per_page?>);

        $j(".paginator").click(function(){
            $j(".paginator").removeClass('active');
            $j(this).addClass('active');

            var pageNum = parseInt($j(this).attr('rel'));
            show_photos(pageNum,<?=$photos_per_page?>);
        });
    </script>

    <?=include_minified($BC->_getFolder('js').'custom/contact_us/send_form.js','inline_js')?>

</body>
</html> 