jQuery.fn.extend({
	bgSlider:function(opt){
		var src=this;
		var block=false,keeper,sCSS={position:'fixed',left:0,top:0,height:'900px',right:0,zIndex:-1,overflow:'hidden'},iCSS={position:'absolute',top:0,left:0,zIndex:-1},spinner;
		dfl={
			interval:4000,
			speed:1500,
			pags:false,
			slideshow:false,
			preload:false,
			current:0,
			bgstretch:false,
			altCSS:false,
			method:'fit'
		}
		opt=jQuery.extend(dfl,opt);
		
		if(opt.pags)opt.pags=jQuery(opt.pags);
		if(opt.preload){
			var tmp=[];
			for(var i=0;i<this.length;i++){
				tmp[i]=new Image();
				tmp[i].src=this[i];
			}
		}
		
		spinner=jQuery(opt.spinner);
		
		var resize=jQuery.fn.bgSlider.resize=function(){
			var im=jQuery('#bgSlider img').eq(0),
				w=im.width(),
				l=im.css('left'),
				t='0px',
				bw=document.body.offsetWidth,
				bh=document.body.offsetHeight,
				k=im.data('width')/im.data('height');
			if(opt.method=='fit')
				if(bw/bh<k)
					im.width('auto').height(bh).css({top:t,left:l});
				else
					im.width(bw).height('auto').css({top:t,left:l});
			else
				if(!(bw/bh<k))
					im.width('auto').height(bh).css({top:t,left:l});
				else
					im.width(bw).height('auto').css({top:t,left:l});

			if(opt.method=='full')
				im.stop().animate({left:(bw-w)/2});
		}
		
		jQuery.extend(jQuery.fn.bgSlider,{changeMethod:function(me){
			opt.method=(opt.method==me)?opt.method:me;
			keeper.trigger('bgSliderRefresh');
		}});
					
		jQuery(window).bind('resize',resize);
		
		var loadSrc=function(src){
			if(!opt.bgstretch)return loadURL(src);
			if(opt.pags)
				//opt.pags.parent().eq(opt.current).addClass('current').siblings().removeClass('current')
				opt.pags=jQuery("#thumbs a");
				opt.pags.filter("[rel="+(parseInt(opt.current+1))+"]").parent().addClass('current').siblings().removeClass('current');
			if(opt.slideshow)
				clearInterval(opt.slideshow),
				opt.slideshow=setInterval(function(){keeper.trigger('bgSliderNext')},opt.interval);
			var t=new Image(),lt=jQuery('img',keeper).eq(0);
			lt.each(function(){lt=this});
			t=jQuery(t);
			t.css(iCSS);
			if(opt.altCSS)t.css(opt.altCSS);
			keeper.append(t);
 			t.bind('load',function(){
				spinner.remove();
				var w=this.offsetWidth,
					h=this.offsetHeight,
					th=jQuery(this);
				th.data({width:w,height:h});
				th.animate({opacity:1},opt.speed,function(){
					jQuery(this).siblings().remove();
					block=false;
					resize();
				});
			})
			t.css({opacity:0,left:lt.offsetLeft,width:lt.offsetWidth,height:lt.offsetHeight}).attr('src',src);
			keeper.append(spinner);
		}
	
		var loadURL=function(src){
			if(opt.pags)
				opt.pags.parent().eq(opt.current).addClass('current').siblings().removeClass('current');
			if(opt.slideshow)
				clearInterval(opt.slideshow),
				opt.slideshow=setInterval(function(){keeper.trigger('bgSliderNext')},opt.interval);
			var t=jQuery('<div></div>').css(iCSS).css({width:'100%',height:'100%',zIndex:-1,'background-image':'url('+src+')'});
			if(opt.altCSS)t.css(opt.altCSS);
			keeper.append(t);
			t.animate({opacity:1},opt.speed,function(){
				jQuery(this).siblings().remove();
				block=false;
			});
		}
		jQuery('body').append(keeper=jQuery('<div id="bgSlider"></div>').css(sCSS));
		
		keeper.bind('bgSliderRefresh',function(){
			if(!block)
				block=true,
				loadSrc(src[opt.current]);
		})
		
		keeper.bind('bgSliderNext',function(){
			if(!block){
				block=true;
				opt.current++;
				if(!(opt.current<src.length))opt.current=0;
				loadSrc(src[opt.current]);
			}
		})
		keeper.bind('bgSliderPrev',function(){
			if(!block){
				block=true;
				if(opt.current==0)opt.current=src.length;
				opt.current--;
				loadSrc(src[opt.current]);
			}
		});
		if(opt.pags)jQuery(opt.pags).live('click',function(){
			if(!block){
				block=true;
				loadSrc(src[opt.current=this.rel-1]);
			}
			return false;
		})
		loadSrc(src[opt.current]);
		
		resize();
	}
});