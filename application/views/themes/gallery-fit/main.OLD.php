<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    
    <title><?=$head['site_title']?><?if($head['page_title']):?> :: <?=$head['page_title']?><?endif?></title>
    
    <?=include_minified($BC->_getTheme().'css/style.css','css')?>
    <?=include_minified($BC->_getTheme().'css/layout.css','css')?>
    
    <?=include_minified($BC->_getTheme().'js/jquery-1.4.3.min.js','js')?>
    <?=include_minified($BC->_getTheme().'js/cufon-yui.js','js')?>
    <?=include_minified($BC->_getTheme().'js/cufon-replace.js','js')?>
    <?=include_minified($BC->_getTheme().'js/Lobster_400.font.js','js')?>
    <?=include_minified($BC->_getTheme().'js/Myriad_Pro_BoldCond_700.font.js','js')?>
    <?=include_minified($BC->_getTheme().'js/bgSlider.js','js')?>
    <?=include_minified($BC->_getTheme().'js/jquery.mousewheel.js','js')?>
    <?=include_minified($BC->_getTheme().'js/jScrollPane.js','js')?>
    <?=include_minified($BC->_getTheme().'js/slidePager.js','js')?>
    <?/*=include_combined(array(
                                $BC->_getTheme().'js/jquery-1.4.3.min.js', 
                                $BC->_getTheme().'js/cufon-yui.js', 
                                $BC->_getTheme().'js/cufon-replace.js', 
                                $BC->_getTheme().'js/Lobster_400.font.js', 
                                $BC->_getTheme().'js/Myriad_Pro_BoldCond_700.font.js',
                                $BC->_getTheme().'js/bgSlider.js',
                                $BC->_getTheme().'js/jquery.mousewheel.js',
                                $BC->_getTheme().'js/jScrollPane.js',
                                $BC->_getTheme().'js/slidePager.js'
                                ),
                        $BC->_getTheme().'js/combined.js','js')*/?>
       
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

<div class="glob"><a class="gall_prev"></a><a class="gall_next"></a>
<aside>
  <nav>
    <ul>
      <li class="active"><a href="#page1" rel="slide">Gallery</a></li>
      <li><a href="#page2" rel="slide">My Bio</a></li>
      <li><a href="#page3" rel="slide">Contacts</a></li>
    </ul>
  </nav>
  <div class="pages">
    <div class="page" id="page1"> <a class="button-method button"><span class="wrap">image view mode</span> <span class="meth">fit</span></a>
      <div class="scroll">
        <ul id="thumbs">
          <li><a href="#" rel="1"><img src="<?=$BC->_getTheme()?>images/thumb1.jpg" alt=""></a></li>
          <li><a href="#" rel="2"><img src="<?=$BC->_getTheme()?>images/thumb2.jpg" alt=""></a></li>
          <li><a href="#" rel="3"><img src="<?=$BC->_getTheme()?>images/thumb3.jpg" alt=""></a></li>
          <li><a href="#" rel="4"><img src="<?=$BC->_getTheme()?>images/thumb4.jpg" alt=""></a></li>
          <li><a href="#" rel="5"><img src="<?=$BC->_getTheme()?>images/thumb5.jpg" alt=""></a></li>
          <li><a href="#" rel="6"><img src="<?=$BC->_getTheme()?>images/thumb6.jpg" alt=""></a></li>
          <li><a href="#" rel="7"><img src="<?=$BC->_getTheme()?>images/thumb7.jpg" alt=""></a></li>
          <li><a href="#" rel="8"><img src="<?=$BC->_getTheme()?>images/thumb8.jpg" alt=""></a></li>
          
          <li><a href="#" rel="9"><img src="<?=$BC->_getTheme()?>images/thumb1.jpg" alt=""></a></li>
          <li><a href="#" rel="10"><img src="<?=$BC->_getTheme()?>images/thumb2.jpg" alt=""></a></li>
          <li><a href="#" rel="11"><img src="<?=$BC->_getTheme()?>images/thumb3.jpg" alt=""></a></li>
          <li><a href="#" rel="12"><img src="<?=$BC->_getTheme()?>images/thumb4.jpg" alt=""></a></li>
          <li><a href="#" rel="13"><img src="<?=$BC->_getTheme()?>images/thumb5.jpg" alt=""></a></li>
          <li><a href="#" rel="14"><img src="<?=$BC->_getTheme()?>images/thumb6.jpg" alt=""></a></li>
          <li><a href="#" rel="15"><img src="<?=$BC->_getTheme()?>images/thumb7.jpg" alt=""></a></li>
          <li><a href="#" rel="16"><img src="<?=$BC->_getTheme()?>images/thumb8.jpg" alt=""></a></li>
          
          <li><a href="#" rel="17"><img src="<?=$BC->_getTheme()?>images/thumb1.jpg" alt=""></a></li>
          <li><a href="#" rel="18"><img src="<?=$BC->_getTheme()?>images/thumb2.jpg" alt=""></a></li>
          <li><a href="#" rel="19"><img src="<?=$BC->_getTheme()?>images/thumb3.jpg" alt=""></a></li>
          <li><a href="#" rel="20"><img src="<?=$BC->_getTheme()?>images/thumb4.jpg" alt=""></a></li>
          <li><a href="#" rel="21"><img src="<?=$BC->_getTheme()?>images/thumb5.jpg" alt=""></a></li>
          <li><a href="#" rel="22"><img src="<?=$BC->_getTheme()?>images/thumb6.jpg" alt=""></a></li>
          <li><a href="#" rel="23"><img src="<?=$BC->_getTheme()?>images/thumb7.jpg" alt=""></a></li>
          <li><a href="#" rel="24"><img src="<?=$BC->_getTheme()?>images/thumb8.jpg" alt=""></a></li>
        </ul>
      </div>
    </div>
    <div class="page" id="page2">
      <div class="scroll"> <img src="<?=$BC->_getTheme()?>images/page2-img1.jpg" class="p2" alt="">
        <p><span class="white">Lorem ipsum dolor sit amet,</span> consec tetuer adipiscing elit. Praesent vestibulum molestie lacus. Aenean nonummy hendrerit mauris. Phasellus porta. Fusce suscipit varius mi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla dui. </p>
        <p><span class="white">Fusce feugiat</span> malesuada odio. Morbi nunc odio, gravida at, cursus nec, luctus a, lorem. Maecenas tristique orci ac sem. Duis ultricies pharetra magna. Donecum accumsan malesuada orci. Donec sit amet eros. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Mauris fermentum dictum magna. Sedume laoreet aliquam leo. Ut tellus dolor, dapibus eget, elementum vel, cursus eleifend, elit. Aenean auctor wisi et urna. Aliquam erat volutpat. Duis ac turpis. Integer rutrum ante eu lacus lorem ipsum dolor.</p>
        <p><span class="white">Fusce feugiat malesuada odio.</span> Morbi nunc odio, gravida at, cursus nec, luctus a, lorem. Maecenas tristique orci ac sem. Duis ultricies pharetra magna. Donec accumsan malesuada orci. Donec sit amet eros. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Mauris fermentum dictum magna. Sedume laoreet aliquam leo. Ut tellus dolor, dapibus eget, elementum vel, cursus eleifend, elit. Aenean auctor wisi et urna. Aliquam erat volutpat. Duis ac turpis. Integer rutrum ante eu lacus omnis iste natus error sit voluptatem.</p>
        <p><span class="white">Lorem ipsum dolor sit amet,</span> consec tetuer adipiscing elit. Praesent vestibulum molestie lacus. Aenean nonummy hendrerit mauris. Phasellus porta. Fusce suscipit varius mi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla dui. </p>
        <p><span class="white">Fusce feugiat</span> malesuada odio. Morbi nunc odio, gravida at, cursus nec, luctus a, lorem. Maecenas tristique orci ac sem. Duis ultricies pharetra magna. Donecum accumsan malesuada orci. Donec sit amet eros. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Mauris fermentum dictum magna. Sedume laoreet aliquam leo. Ut tellus dolor, dapibus eget, elementum vel, cursus eleifend, elit. Aenean auctor wisi et urna. Aliquam erat volutpat. Duis ac turpis. Integer rutrum ante eu lacus lorem ipsum dolor.</p>
        <p><span class="white">Fusce feugiat malesuada odio.</span> Morbi nunc odio, gravida at, cursus nec, luctus a, lorem. Maecenas tristique orci ac sem. Duis ultricies pharetra magna. Donec accumsan malesuada orci. Donec sit amet eros. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Mauris fermentum dictum magna. Sedume laoreet aliquam leo. Ut tellus dolor, dapibus eget, elementum vel, cursus eleifend, elit. Aenean auctor wisi et urna. Aliquam erat volutpat. Duis ac turpis. Integer rutrum ante eu lacus omnis iste natus error sit voluptatem.</p>
      </div>
    </div>
    <div class="page" id="page3">
      <div class="croll">
        <p><span class="white">Lorem ipsum dolor sit amet,</span> consec tetuer adipiscing elit. Praesent vestibulum molestie lacus. Aenean nonummy hendrerit mauris. Phasellus porta. Fuscemen suscipit varius miCum sociis natoque penatibus et magnis dis parturient montes nascetur ridiculus mus. Nulla dui malesuada odio. Morbi nunc odio, gravida ate cursus nec, luctus a, lorem. Maecenas tristique orci ac sem. </p>
        <div class="extra-wrap p2">
          <dl class="address und">
            <dt>8901 Marmora Road, Glasgow, D04 89GR.</dt>
            <dd><span>Freephone: +1 800 559 6580;  Telephone: +1 959 603 6035</span></dd>
            <dd><span>E-mail: <a href="#">mail@demolink.org</a></span></dd>
          </dl>
        </div>
        <form action="" id="form1">
          <label>Enter your name:
            <input type="text">
          </label>
          <label>Enter your e-mail:
            <input type="text">
          </label>
          <label>Enter your fax:
            <input type="text">
          </label>
          <label>Enter your message:
            <textarea></textarea>
          </label>
          <div class="btns und"> <a href="javascript:document.getElementById('form1').reset()">Reset</a> <a href="javascript:document.getElementById('form1').submit()">Submit</a> </div>
        </form>
      </div>
    </div>
    <div class="page" id="privacy">
      <div class="croll">
        <p class="white">Privacy Policy</p>
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent vestibulum molestie lacus. Aenean nonummy hendrerit mauris. Phasellus porta. Fusceme suscipit varius mi Cum sociis natoque penatibus et magnis dis parturient montes nascetur ridiculus mus. Nulla dui. Fusce feugiat malesuada odio. Morbi nuncem odio, gravida at, cursus nec, luctus a, lorem. Maecenas tristique orci ac sem. Duis ultricies pharetra magna. Donec accumsan malesuada orci. Donec sit amet eros. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. </p>
        <p>Mauris fermentum dictum magna Sed laoreet aliquam leo Utellus dolor dapibus eget elementum vel, cursus eleifend, elit. Aenean auctor wisi etume urnamenu. Aliquam erat volutpat. Duis ac turpis. Integer rutrum ante eu lacus. Quisquemen nulla. Vestibulum libero nisl, porta vel, scelerisque eget, malesuada atem neque Vivamus eget nibh. Etiam cursus leo vel metus. Nulla facilisi. Aenean nec eros. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse sollicitudin velit.</p>
        <p>sed leo. Ut pharetra augue nec augue. Nam elit magna, hendrerit sit amet, tincidunt ac, viverra sed, nulla. Donec porta diam eu massa. Quisque diam lorem, interdum vitae, dapibus ac, scelerisque vitae, pede. Donec eget tellus non erat lacinia fermentum. Donec in velit vel ipsum auctor pulvinar. Proin ullamcorper urna et felis. Vestibulum iaculis lacinia est. Proin dictum elementum velit. Fusce euismod consequat ante. Lorem ipsum dolor siteme amet, consectetuer adipiscing elit. Pellentesque sed dolor Aliquam congue fermentum nisl Mauris accumsan nulla vel diam. Sed in lacus ut enim.</p>
        <p>adipiscing aliquet. Nulla venenatis In pede mi aliquet sit amet euismod in auctor ut, ligula. Aliquam dapibus tincidunt metus. Praesent justo dolorem, lobortiseme quis, lobortis dignissim, pulvinar ac, lorem. Vestibulum sed ante. Donec sagittis euismod purus Sed uperspiciatis unde omnis iste natus error sitem voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunteme explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione.</p>
        <p>E-mail: <a href="#" class="und">info@demolink.org</a></p>
      </div>
    </div>
  </div>
</aside>
<footer>
  <h1><a href="index.html">Katy Johnson</a><span class="slogan">The art of <span class="white">photography</span></span></h1>
  <pre class="privacy">Katy Johnson &copy; 2010  <a href="#privacy" rel="slide" class="white und">Privacy Policy</a><br /><!-- {%FOOTER_LINK} -->
</pre>
</footer>

</div>

<script type="text/javascript">
var slidesArr = ['themes/gallery-fit/images/pic1.jpg',	'themes/gallery-fit/images/pic2.jpg',	'themes/gallery-fit/images/pic3.jpg',	'themes/gallery-fit/images/pic4.jpg',	'themes/gallery-fit/images/pic5.jpg',	'themes/gallery-fit/images/pic6.jpg',	'themes/gallery-fit/images/pic7.jpg',	'themes/gallery-fit/images/pic8.jpg'];
</script>
<?=include_minified($BC->_getTheme().'js/main.js','js')?>

</body>
</html> 