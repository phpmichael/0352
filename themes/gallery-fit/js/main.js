$j = jQuery.noConflict();

$j(window).load(function(){
	$j('.scroll').jScrollPane({showArrows:false,scrollbarWidth:25,dragMaxHeight:105,scrollbarHeight:175});
})
$j(function(){
	$j(window.slidesArr).bgSlider({
					  preload:false,
					  bgstretch:true,
					  current:0,
					  pags:'#thumbs',
					  spinner:'<span class="spinner"></span>'
				  });
	
	$j('#bgSlider').css({left:'586px'});
	
	$j('.pages').slidePager({pagernav:'aside nav li'});
	
	var moving=true,
		footer=$j('footer').hide(),
		wH=$j(window).height();
	$j(window).bind('resize',function(){
		wH=$j(window).height();
	});
	$j('aside').on('mousemove',function(){moving=false});
	
	$j(document).bind('mousemove',function(e){
		var gallact=$j('aside nav li').eq(0).hasClass('active'),
			imag=$j('#bgSlider img'),
			asideV=true;
		
		if(e.clientX>586&&gallact&&!moving)
			$j('aside').stop().animate({left:-586+'px'},{step:function(now){
				$j('#bgSlider').css({left:586+now+'px'});
			},complete:function(){
				moving=false;
				$j('body .gall_prev,body .gall_next').show().css({opacity:.7});
				$j().bgSlider.resize();
				asideV=true;
			}}),
			moving=true;
		if(e.clientX<40||e.clientX>586&&!gallact&&!moving)
			imag.eq(0).stop(),
			imag.animate({left:0},function(){
				$j('aside').stop().animate({left:0},{
					step:function(now){
						$j('#bgSlider').css({left:586+now+'px'});
					},complete:function(){
						$j('body .gall_prev,body .gall_next').hide();
						asideV=false;
					}});
			}),
			moving=true;

		if(wH-e.clientY<100)
			footer.fadeIn();
		else
			footer.fadeOut();
	})
	
	$j('.gall_prev,.gall_next')
		.on('mouseenter',function(){
			$j(this).stop().animate({opacity:1});
		})
		.on('mouseleave',function(){
			$j(this).stop().animate({opacity:.7});
		})
	
	$j('body .gall_prev,body .gall_next').on('click',function(){
		if($j(this).hasClass('gall_next'))
			$j('#bgSlider').trigger('bgSliderNext');
		else
			$j('#bgSlider').trigger('bgSliderPrev');
		return false
	})
	
	$j('#thumbs a').append('<span class="fader"></span>');
	
	$j('#thumbs').on('mouseover', 'a',function(){
        $j(this).find('.fader').css({display:'block',opacity:0}).stop().animate({opacity:.73})
    });
	$j('#thumbs').on('mouseout', 'a',function(){
        $j(this).find('.fader').stop().animate({opacity:0},function(){$j(this).css({display:'none'})})
    });
	
	var methods=['fit','full'];
	$j('.button-method').on('click',function(){		
		methods.push(methods.shift());
		$j('>span.meth',this).text(methods[0]);
		$j().bgSlider.changeMethod(methods[0]);
		return false;
	})
})