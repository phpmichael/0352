<?
//get photos list
$photos_model = load_model('photos_model');
$photosData = $photos_model->getPhotos(0,0,999,'id','desc');
$photos = $photosData['list'];

//get pages data
$pages['contacts'] = $BC->pages_model->getByLink('contact_us');
$pages['about'] = $BC->pages_model->getByLink('about');
$pages['about_makeup'] = $BC->pages_model->getBySlug('pro-makiyazh');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title><?=$head['site_title']?></title>
        <link rel="stylesheet" href="https://ajax.aspnetcdn.com/ajax/jquery.mobile/1.1.1/jquery.mobile-1.1.1.min.css" />
        <?=include_minified($BC->_getTheme().'css/my.css','css')?>
        <style>
            h1{font-size:25px !important;}
            h5{font-size:12px !important;}
            .red, .required{color:red;}
            .green, .success{color:green;}
            #gallery{}
            #gallery img{float:left;margin:1px;}
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.mobile/1.1.1/jquery.mobile-1.1.1.min.js"></script>
        <?=include_minified($BC->_getTheme().'js/my.js','js')?>
    </head>
    <body>
    
        <!-- Gallery Page -->
        <div data-role="page" id="page1" data-title="<?=$head['site_title']?> :: Галерея">
            <div data-theme="a" data-role="header">
                <h1>
                    Галерея
                </h1>
                <div data-role="navbar" data-iconpos="right">
                    <ul>
                        <li>
                            <a href="#page1" data-theme="" data-icon="grid" class="ui-btn-active ui-state-persist">
                                Галерея
                            </a>
                        </li>
                        <li>
                            <a href="#page2" data-theme="" data-icon="info">
                                Про мене
                            </a>
                        </li>
                        <li>
                            <a href="#page3" data-theme="" data-icon="arrow-r">
                                Контакти
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div data-role="content" style="padding: 5px">
                <div id="gallery"></div>
                <div style="clear:both"></div>
                <p><a href="javascript:;" data-role="button" data-inline="true" data-icon="down" id="more_photos">More</a></p>
            </div>
            <div data-theme="a" data-role="footer">
                <h5>
                    Maria Kovalska &copy; 2012 <a href="#about_makeup">Про макіяж</a>
                </h5>
            </div>
        </div>
        
        <!-- About Page -->
        <div data-role="page" id="page2" data-title="<?=$head['site_title']?> :: Про мене">
            <div data-theme="a" data-role="header">
                <h1>
                    Про мене
                </h1>
                <div data-role="navbar" data-iconpos="right">
                    <ul>
                        <li>
                            <a href="#page1" data-theme="" data-icon="grid">
                                Галерея
                            </a>
                        </li>
                        <li>
                            <a href="#page2" data-theme="" data-icon="info" class="ui-btn-active ui-state-persist">
                                Про мене
                            </a>
                        </li>
                        <li>
                            <a href="#page3" data-theme="" data-icon="arrow-r">
                                Контакти
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div data-role="content" style="padding: 15px">
                <img src="<?=$BC->_getTheme()?>images/maria-kovalska.jpg" width="350" height="258" class="p2" alt="Maria Kovalska">
                <?=$pages['about']['body']?>
            </div>
            <div data-theme="a" data-role="footer">
                <h5>
                    Maria Kovalska &copy; 2012 <a href="#about_makeup">Про макіяж</a>
                </h5>
            </div>
        </div>
        
        <!-- Contacts Page -->
        <div data-role="page" id="page3" data-title="<?=$head['site_title']?> :: Контакти">
            <div data-theme="a" data-role="header">
                <h1>
                    Контакти
                </h1>
                <div data-role="navbar" data-iconpos="right">
                    <ul>
                        <li>
                            <a href="#page1" data-theme="" data-icon="grid">
                                Галерея
                            </a>
                        </li>
                        <li>
                            <a href="#page2" data-theme="" data-icon="info">
                                Про мене
                            </a>
                        </li>
                        <li>
                            <a href="#page3" data-theme="" data-icon="arrow-r" class="ui-btn-active ui-state-persist">
                                Контакти
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div data-role="content" style="padding: 15px">
                <?=$pages['contacts']['body']?>
            </div>
            <div data-theme="a" data-role="footer">
                <h5>
                    Maria Kovalska &copy; 2012 <a href="#about_makeup">Про макіяж</a>
                </h5>
            </div>
        </div>
        
        <!-- About Make-up -->
        <div data-role="page" id="about_makeup" data-title="<?=$head['site_title']?> :: Про макіяж">
            <div data-theme="a" data-role="header">
                <h1>
                    Про макіяж
                </h1>
                <div data-role="navbar" data-iconpos="right">
                    <ul>
                        <li>
                            <a href="#page1" data-theme="" data-icon="grid">
                                Галерея
                            </a>
                        </li>
                        <li>
                            <a href="#page2" data-theme="" data-icon="info">
                                Про мене
                            </a>
                        </li>
                        <li>
                            <a href="#page3" data-theme="" data-icon="arrow-r">
                                Контакти
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div data-role="content" style="padding: 15px">
                <?=$pages['about_makeup']['body']?>
                <p><?=$BC->settings_model['site_partners']?></p>
            </div>
            <div data-theme="a" data-role="footer">
                <h5>
                    Maria Kovalska &copy; 2012 <a href="#about_makeup">Про макіяж</a>
                </h5>
            </div>
        </div>
        
        <script>
            $j = jQuery.noConflict();
            
            var lastPhoto = 1;
            var photos = [];
            
            <?$i=0;foreach ($photos as $record):$i++;?>
            photos[<?=$i?>] = '<?=$record['file_name']?>';
            <?endforeach?>
            
            function show_photos(count)
            {
                var i = lastPhoto;
                lastPhoto += count;
                
                while(i<lastPhoto)
                {
                    if(i>=photos.length) 
                    {
                        $j("#more_photos").hide();
                        break;
                    }
                    
                    $j("#gallery").append("<img src='<?=base_url().'images/data/s/photos/'?>"+photos[i]+"' width='230' height='162' alt='' />");
                    i++;
                }
                
            }
            
            show_photos(6);
            
            $j("#more_photos").click(function(){
                show_photos(6);
            });
        </script>
    </body>
</html>