jQuery.fn.extend({
	bgSlider:function(opt){
		var src = this;
		var block = false,
            keeper,
            sCSS = {position:'fixed',left:0,top:0,height:'900px',right:0,overflow:'hidden'},
            iCSS = {position:'absolute',top:0,left:0},
            spinner;

		var defaultOptions = {
			interval:4000,
			speed:1500,
			slideshow:false,
			preload:false,
			current:0,
			method:'fit'
		}
		opt = jQuery.extend(defaultOptions,opt);
		
		opt.pags = jQuery(opt.pags);

		if(opt.preload){
			var tmp=[];
			for(var i=0; i<this.length; i++){
				tmp[i] = new Image();
				tmp[i].src = this[i];
			}
		}
		
		spinner = jQuery(opt.spinner);
		
		var resize = jQuery.fn.bgSlider.resize = function(){
			var image = jQuery('#bgSlider').find('img').eq(0),
				w = image.width(),
				l = image.css('left'),
				t = '0px',
				bw = document.body.offsetWidth,
				bh = document.body.offsetHeight,
				k = image.data('width')/image.data('height');

			if(opt.method == 'fit')
				if(bw/bh<k)
					image.width('auto').height(bh).css({top:t,left:'0px'});
				else
					image.width(bw).height('auto').css({top:t,left:'0px'});
			else
				if(!(bw/bh<k))
					image.width('auto').height(bh).css({top:t,left:l});
				else
					image.width(bw).height('auto').css({top:t,left:l});

			if(opt.method=='full')
				image.stop().animate({left:(bw-w)/2});
		}
		
		jQuery.extend(jQuery.fn.bgSlider,{changeMethod:function(method){
			opt.method = method;
			keeper.trigger('bgSliderRefresh');
		}});

		jQuery(window).bind('resize',resize);

        //load slide
		var loadSrc=function(src){
		    opt.pags.find("a").filter("[rel="+(parseInt(opt.current+1))+"]").parent().addClass('current').siblings().removeClass('current');

			if(opt.slideshow){
				clearInterval(opt.slideshow);
				opt.slideshow=setInterval(function(){keeper.trigger('bgSliderNext')},opt.interval);
            }

			var t = new Image(),
                lt = jQuery('img', keeper).eq(0);

			lt.each(function(){
                lt=this
            });
			t = jQuery(t);
			t.css(iCSS);

			keeper.append(t);

 			t.bind('load',function(){
				spinner.remove();

				var w=this.offsetWidth,
					h=this.offsetHeight,
					th=jQuery(this);

				th.data({width:w,height:h});
				th.animate({opacity:1},opt.speed,function(){
					jQuery(this).siblings().remove();
					block = false;
					resize();
				});
			})
			t.css({opacity:0,left:lt.offsetLeft,width:lt.offsetWidth,height:lt.offsetHeight}).attr('src',src);
			keeper.append(spinner);
		}

        //create slider
		jQuery('body').append(keeper = jQuery('<div id="bgSlider"></div>').css(sCSS));

		//when trigger refresh - load current slide
		keeper.bind('bgSliderRefresh',function(){
			if(!block){
                block=true;
                loadSrc(src[opt.current]);
            }
		});

		//load next slide
		keeper.bind('bgSliderNext',function(){
			if(!block){
				block = true;
				opt.current++;
				if(!(opt.current<src.length)) opt.current = 0;
				loadSrc(src[opt.current]);
			}
		});
        //load previous slide
		keeper.bind('bgSliderPrev',function(){
			if(!block){
				block = true;
				if(opt.current == 0) opt.current = src.length;
				opt.current--;
				loadSrc(src[opt.current]);
			}
		});

        //click on thumbs
		opt.pags.on('click', 'a',function(){
			if(!block){
				block = true;
				loadSrc(src[opt.current=this.rel-1]);
			}
			return false;
		});

        //load first slide
		loadSrc(src[opt.current]);
        //resize image based on method
		resize();
	}
});