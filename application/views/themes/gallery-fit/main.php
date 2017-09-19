<?
//get photos list
$photos_model = load_model('photos_model');
$photosData = $photos_model->getPhotos(0,0,999,'id','desc');
$photos = $photosData['list'];
$photos_per_page = 10;
$photos_pages_count = ceil(count($photos)/$photos_per_page);


//get pages data
$pages['contacts'] = $BC->pages_model->getByLink('contact_us');
$pages['about'] = $BC->pages_model->getByLink('about');
$pages['about_makeup'] = $BC->pages_model->getBySlug('pro-makiyazh');
?>
<!DOCTYPE HTML>
<html lang="uk">
<head>
    <meta charset="UTF-8">

    <title><?=$head['site_title']?></title>

    <meta name='description' content='<?=$head['meta_description']?>' />

    <?=include_minified($BC->_getTheme().'css/style.css','css')?>
    <!--[if IE]>
    <?=include_minified($BC->_getTheme().'css/ie_style.css','css')?>
    <![endif]-->

    <!--[if lt IE 7]>
    <?=include_minified($BC->_getTheme().'js/ie6_script_other.js','js')?>
    <![endif]-->
    <!--[if lt IE 9]>
    <?=include_minified($BC->_getTheme().'js/html5.js','js')?>
    <?=include_minified($BC->_getTheme().'js/multiplyBG.js','js')?>
    <![endif]-->

</head>

<body>

<?load_theme_view('inc/tpl-noscript')?>

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
                    <img data-src="<?=static_url().$BC->_getTheme()?>images/maria-kovalska.jpg" width="510" height="376" class="p2" alt="Maria Kovalska">
                    <?=$pages['about']['body']?>
                </div>
            </div>
            <div class="page" id="page3">
                <div class="scroll">
                    <a href="https://www.facebook.com/mariia.kovalska" target="_blank"><img data-src="<?=static_url().$BC->_getTheme()?>images/facebook.png" width="24" height="24" alt="Facebook"></a>
                    <a href="https://vk.com/maria.kovalska" target="_blank"><img data-src="<?=static_url().$BC->_getTheme()?>images/vkontakte.png" width="24" height="24" alt="VKontakte"></a>

                    <?=$pages['contacts']['body']?>
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
            <a href="<?=base_url()?>">Марія Ковальська</a>
            <span class="slogan">Візажист <span class="white">в Тернополі</span></span>
        </h1>
        <div class="privacy">
            Maria Kovalska &copy; 2012
            <a href="#page4" rel="slide" class="white und">
                <?=$pages['about_makeup']['page_title']?>
            </a>
        </div>
    </footer>

</div>

<?=include_combined(array(
        $BC->_getTheme().'js/jquery-1.12.1.min.js',
        $BC->_getTheme().'js/bgSlider.js',
        $BC->_getTheme().'js/slidePager.js',
        $BC->_getTheme().'js/main.js'
    ),
    $BC->_getTheme().'js/combined.js','js')?>

<script>
    var slidesUrl = '<?=static_url().'images/data/b/photos/'?>';

    var slidesArr = [];
    <?$i=-1; foreach ($photos as $record): $i++;?>
    slidesArr[<?=$i?>] = slidesUrl+'<?=$record['file_name']?>';
    <?endforeach?>

    function show_photos(pageNum,perPage)
    {
        var i = (pageNum-1)*perPage;
        var lastPhoto = i+perPage;

        $j("#thumbs").empty().hide();

        while(i<lastPhoto)
        {
            if(i>=slidesArr.length) break;

            $j("#thumbs").append("<li><a href='javascript:;' rel='"+(i+1)+"'><img src='"+slidesArr[i].replace('/b/','/s/')+"' width='230' height='162' alt='' /></a></li>");
            i++;
        }
        $j('#thumbs a').append('<span class="fader"></span>');
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

</body>
</html> 