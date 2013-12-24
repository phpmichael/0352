<?
$BC->load->helper('formbuilder');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <meta charset="utf-8">

        <title><?=$BC->_getPageTitle()?></title>

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <?=include_minified('css/zero.css','css')?>

        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" type="text/css" rel="stylesheet">
        <!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->


        <?=include_minified($BC->_getTheme().'css/styles.css','css')?>
        <?=include_minified('css/fb/styles.css','css')?>
        <?//=include_minified('themes/admin/default/fb/styles.css','css')?>

    </head>
    
    <body  >
        
        <div class="container">
            <h1>Bootstrap and Isotope</h1>

            <div id="posts" class="row">

                <?
                $slideshow = load_model('slideshow_model');
                $slides = $slideshow->getAll();
                ?>

                <?foreach ($slides as $slide):?>
                <div class="item col-md-3">
                    <div class="well">
                        <h4><a href="<?=$slide['link']?>"><?=htmlspecialchars($slide['title'])?></a></h4>
                        <img class="thumbnail img-responsive" src="<?=base_url()?>images/data/s/slideshow/<?=$slide['image']?>" alt="<?=htmlspecialchars($slide['title'])?>" />
                        <div class="info">
                            <?=htmlspecialchars($slide['description'])?>
                        </div>
                    </div>
                </div>
                <?endforeach?>

                <div class="item col-md-6">
                    <div class="well">
                        <?fb_form('agenda')?>
                    </div>
                </div>

                <?for($i=1;$i<=8;$i++):?>
                <div id="<?=$i?>" class="item col-md-3">
                    <div class="well">
                        <h4><a href="#" target="_blank">Item <?=$i?></a></h4>
                        <img class="thumbnail img-responsive" src="//lorempixel.com/150/180">
                        <div class="info">
                            <span class="badge">90</span>
                            <span class="badge">42</span>
                        </div>
                    </div>
                </div>
                <?endfor?>

            </div>
        </div>

        <footer class="text-center"></footer>
        
        <script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

        <script type='text/javascript' src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
        
        <script type='text/javascript'>
        
        $(document).ready(function() {
        
            $.getScript('//cdn.jsdelivr.net/isotope/1.5.25/jquery.isotope.min.js',function(){

                /* activate jquery isotope */
                $('#posts').imagesLoaded( function(){
                    $('#posts').isotope({
                      itemSelector : '.item'
                    });
                });
  
            });
        
        });
        
        </script>
        
    </body>
</html>