$j = jQuery.noConflict();

$j(function(){
    var asideWidth = 586;

    //init slider for images
	$j(window.slidesArr).bgSlider({
        pags:'#thumbs',
        spinner:'<span class="spinner"></span>'
    });
	
	$j('#bgSlider').css({left:asideWidth+'px'});

    //init slider for pages
	$j('.pages').slidePager({pagernav:'aside nav li'});
	
	var moving = true,
        asideVisible = true,
        activeSlide = $j('#bgSlider').find('img').eq(0),
		footer = $j('footer').hide(),
		windowHeight = $j(window).height();

	$j(window).bind('resize',function(){
		windowHeight = $j(window).height();
	});

	$j('aside').on('mousemove',function(){
        moving = false;
    });
	
	$j(document).bind('mousemove',function(e){
		var galleryActive = $j('aside nav li').eq(0).hasClass('active');

        //hover on slide and active gallery page and sidebar visible
		if(e.clientX>asideWidth && galleryActive && !moving && asideVisible){
			$j('aside').stop().animate({left:-asideWidth+'px'},{step:function(now){
				$j('#bgSlider').css({left:asideWidth+now+'px'});
			},complete:function(){
				moving = false;
				$j('.gall_prev, .gall_next').show().css({opacity:.7});
				$j().bgSlider.resize();
                asideVisible = false;
			}});
			moving = true;
        }
        //sidebar hidden and hover on left side slide or gallery page not active
		if( (e.clientX<40 || e.clientX>asideWidth && !galleryActive && !moving) && !asideVisible ){
			activeSlide.stop();
			activeSlide.animate({left:0},function(){
				$j('aside').stop().animate({left:0},{
					step:function(now){
						$j('#bgSlider').css({left:asideWidth+now+'px'});
					},complete:function(){
						$j('.gall_prev, .gall_next').hide();
                        asideVisible = true;
					}});
			});
			moving = true;
        }
        //hover on footer area
		if(windowHeight - e.clientY < 100)
			footer.fadeIn();
		else
			footer.fadeOut();
	});

    $j(document).on('click tap', activeSlide, function(e){
        if(asideVisible || !asideVisible && e.clientX<40){
            moving = false;
            $j(document).trigger('mousemove', {clientX: e.clientX, clientY: e.clientY});
        }
    });

    //hover on buttons prev/next
	$j('.gall_prev, .gall_next')
		.on('mouseenter',function(){
			$j(this).stop().animate({opacity:1});
		})
		.on('mouseleave',function(){
			$j(this).stop().animate({opacity:.7});
		});

    //click on buttons prev/next
	$j('.gall_prev, .gall_next').on('click',function(){
		if($j(this).hasClass('gall_next'))
			$j('#bgSlider').trigger('bgSliderNext');
		else
			$j('#bgSlider').trigger('bgSliderPrev');
		return false;
	})

    //add fader for each thumb
	$j('#thumbs a').append('<span class="fader"></span>');

    //hover on thumb
	$j('#thumbs').on('mouseover', 'a',function(){
        $j(this).find('.fader').css({display:'block',opacity:0}).stop().animate({opacity:.73})
    });
	$j('#thumbs').on('mouseout', 'a',function(){
        $j(this).find('.fader').stop().animate({opacity:0},function(){$j(this).css({display:'none'})})
    });
	
	var methods = ['fit','full'];
	$j('.button-method').on('click',function(){		
		methods.push(methods.shift());
		$j('>span.meth',this).text(methods[0]);
		$j().bgSlider.changeMethod(methods[0]);
		return false;
	});
})