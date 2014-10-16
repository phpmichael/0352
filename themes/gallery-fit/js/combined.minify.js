
// @fileRef bgSlider.js 
jQuery.fn.extend({bgSlider:function(opt){var src=this;var block=false,keeper,sCSS={position:'fixed',left:0,top:0,height:'900px',right:0,zIndex:-1,overflow:'hidden'},iCSS={position:'absolute',top:0,left:0,zIndex:-1},spinner;dfl={interval:4000,speed:1500,pags:false,slideshow:false,preload:false,current:0,bgstretch:false,altCSS:false,method:'fit'}
opt=jQuery.extend(dfl,opt);if(opt.pags)opt.pags=jQuery(opt.pags);if(opt.preload){var tmp=[];for(var i=0;i<this.length;i++){tmp[i]=new Image();tmp[i].src=this[i];}}
spinner=jQuery(opt.spinner);var resize=jQuery.fn.bgSlider.resize=function(){var im=jQuery('#bgSlider img').eq(0),w=im.width(),l=im.css('left'),t='0px',bw=document.body.offsetWidth,bh=document.body.offsetHeight,k=im.data('width')/im.data('height');if(opt.method=='fit')
if(bw/bh<k)
im.width('auto').height(bh).css({top:t,left:l});else
im.width(bw).height('auto').css({top:t,left:l});else
if(!(bw/bh<k))
im.width('auto').height(bh).css({top:t,left:l});else
im.width(bw).height('auto').css({top:t,left:l});if(opt.method=='full')
im.stop().animate({left:(bw-w)/2});}
jQuery.extend(jQuery.fn.bgSlider,{changeMethod:function(me){opt.method=(opt.method==me)?opt.method:me;keeper.trigger('bgSliderRefresh');}});jQuery(window).bind('resize',resize);var loadSrc=function(src){if(!opt.bgstretch)return loadURL(src);if(opt.pags)
opt.pags=jQuery("#thumbs a");opt.pags.filter("[rel="+(parseInt(opt.current+1))+"]").parent().addClass('current').siblings().removeClass('current');if(opt.slideshow)
clearInterval(opt.slideshow),opt.slideshow=setInterval(function(){keeper.trigger('bgSliderNext')},opt.interval);var t=new Image(),lt=jQuery('img',keeper).eq(0);lt.each(function(){lt=this});t=jQuery(t);t.css(iCSS);if(opt.altCSS)t.css(opt.altCSS);keeper.append(t);t.bind('load',function(){spinner.remove();var w=this.offsetWidth,h=this.offsetHeight,th=jQuery(this);th.data({width:w,height:h});th.animate({opacity:1},opt.speed,function(){jQuery(this).siblings().remove();block=false;resize();});})
t.css({opacity:0,left:lt.offsetLeft,width:lt.offsetWidth,height:lt.offsetHeight}).attr('src',src);keeper.append(spinner);}
var loadURL=function(src){if(opt.pags)
opt.pags.parent().eq(opt.current).addClass('current').siblings().removeClass('current');if(opt.slideshow)
clearInterval(opt.slideshow),opt.slideshow=setInterval(function(){keeper.trigger('bgSliderNext')},opt.interval);var t=jQuery('<div></div>').css(iCSS).css({width:'100%',height:'100%',zIndex:-1,'background-image':'url('+src+')'});if(opt.altCSS)t.css(opt.altCSS);keeper.append(t);t.animate({opacity:1},opt.speed,function(){jQuery(this).siblings().remove();block=false;});}
jQuery('body').append(keeper=jQuery('<div id="bgSlider"></div>').css(sCSS));keeper.bind('bgSliderRefresh',function(){if(!block)
block=true,loadSrc(src[opt.current]);})
keeper.bind('bgSliderNext',function(){if(!block){block=true;opt.current++;if(!(opt.current<src.length))opt.current=0;loadSrc(src[opt.current]);}})
keeper.bind('bgSliderPrev',function(){if(!block){block=true;if(opt.current==0)opt.current=src.length;opt.current--;loadSrc(src[opt.current]);}});if(opt.pags)jQuery(opt.pags).live('click',function(){if(!block){block=true;loadSrc(src[opt.current=this.rel-1]);}
return false;})
loadSrc(src[opt.current]);resize();}});

// @fileRef jquery.mousewheel.minify.js 
(function($){var types=['DOMMouseScroll','mousewheel'];$.event.special.mousewheel={setup:function(){if(this.addEventListener)
for(var i=types.length;i;)
this.addEventListener(types[--i],handler,false);else
this.onmousewheel=handler;},teardown:function(){if(this.removeEventListener)
for(var i=types.length;i;)
this.removeEventListener(types[--i],handler,false);else
this.onmousewheel=null;}};$.fn.extend({mousewheel:function(fn){return fn?this.bind("mousewheel",fn):this.trigger("mousewheel");},unmousewheel:function(fn){return this.unbind("mousewheel",fn);}});function handler(event){var args=[].slice.call(arguments,1),delta=0,returnValue=true;event=$.event.fix(event||window.event);event.type="mousewheel";if(event.wheelDelta)delta=event.wheelDelta/120;if(event.detail)delta=-event.detail/3;args.unshift(event,delta);return $.event.handle.apply(this,args);}})(jQuery);

// @fileRef jScrollPane.minify.js 
jQuery.jScrollPane={active:[]};jQuery.fn.jScrollPane=function(settings)
{settings=jQuery.extend({scrollbarWidth:10,scrollbarMargin:5,wheelSpeed:18,showArrows:false,arrowSize:0,animateTo:false,dragMinHeight:1,dragMaxHeight:99999,animateInterval:100,animateStep:3,maintainPosition:true,scrollbarOnLeft:false},settings);return this.each(function()
{var $this=jQuery(this);if(jQuery(this).parent().is('.jScrollPaneContainer')){var currentScrollPosition=settings.maintainPosition?$this.offset({relativeTo:jQuery(this).parent()[0]}).top:0;var $c=jQuery(this).parent();var paneWidth=$c.innerWidth();var paneHeight=$c.outerHeight();var trackHeight=paneHeight;if($c.unmousewheel){$c.unmousewheel();}
jQuery('>.jScrollPaneTrack, >.jScrollArrowUp, >.jScrollArrowDown',$c).remove();$this.css({'top':0});}else{var currentScrollPosition=0;this.originalPadding=$this.css('paddingTop')+' '+$this.css('paddingRight')+' '+$this.css('paddingBottom')+' '+$this.css('paddingLeft');this.originalSidePaddingTotal=(parseInt($this.css('paddingLeft'))||0)+(parseInt($this.css('paddingRight'))||0);var paneWidth=$this.innerWidth();var paneHeight=$this.innerHeight();var trackHeight=paneHeight;$this.wrap(jQuery('<div></div>').attr({'className':'jScrollPaneContainer'}).css({'height':paneHeight+'px','width':paneWidth+'px'}));jQuery(document).bind('emchange',function(e,cur,prev)
{$this.jScrollPane(settings);});}
var p=this.originalSidePaddingTotal;var cssToApply={'height':'auto','width':paneWidth-settings.scrollbarWidth-settings.scrollbarMargin-p+'px'}
if(settings.scrollbarOnLeft){cssToApply.paddingLeft=settings.scrollbarMargin+settings.scrollbarWidth+'px';}else{cssToApply.paddingRight=settings.scrollbarMargin+'px';}
$this.css(cssToApply);var contentHeight=$this.outerHeight();var percentInView=paneHeight/contentHeight;if(percentInView<.99){var $container=$this.parent();$container.append(jQuery('<div></div>').attr({'className':'jScrollPaneTrack'}).css({'width':settings.scrollbarWidth+'px'}).append(jQuery('<div></div>').attr({'className':'jScrollPaneDrag'}).css({'width':settings.scrollbarWidth+'px'}).append(jQuery('<div></div>').attr({'className':'jScrollPaneDragTop'}).css({'width':settings.scrollbarWidth+'px'}),jQuery('<div></div>').attr({'className':'jScrollPaneDragBottom'}).css({'width':settings.scrollbarWidth+'px'}))));var $track=jQuery('>.jScrollPaneTrack',$container);var $drag=jQuery('>.jScrollPaneTrack .jScrollPaneDrag',$container);if(settings.showArrows){var currentArrowButton;var currentArrowDirection;var currentArrowInterval;var currentArrowInc;var whileArrowButtonDown=function()
{if(currentArrowInc>4||currentArrowInc%4==0){positionDrag(dragPosition+currentArrowDirection*mouseWheelMultiplier);}
currentArrowInc++;};var onArrowMouseUp=function(event)
{jQuery('html').unbind('mouseup',onArrowMouseUp);currentArrowButton.removeClass('jScrollActiveArrowButton');clearInterval(currentArrowInterval);};var onArrowMouseDown=function(){jQuery('html').bind('mouseup',onArrowMouseUp);currentArrowButton.addClass('jScrollActiveArrowButton');currentArrowInc=0;whileArrowButtonDown();currentArrowInterval=setInterval(whileArrowButtonDown,100);};$container.append(jQuery('<a></a>').attr({'href':'javascript:;','className':'jScrollArrowUp'}).css({'width':settings.scrollbarWidth+'px'}).html('Scroll up').bind('mousedown',function()
{currentArrowButton=jQuery(this);currentArrowDirection=-1;onArrowMouseDown();this.blur();return false;}),jQuery('<a></a>').attr({'href':'javascript:;','className':'jScrollArrowDown'}).css({'width':settings.scrollbarWidth+'px'}).html('Scroll down').bind('mousedown',function()
{currentArrowButton=jQuery(this);currentArrowDirection=1;onArrowMouseDown();this.blur();return false;}));var $upArrow=jQuery('>.jScrollArrowUp',$container);var $downArrow=jQuery('>.jScrollArrowDown',$container);if(settings.arrowSize){trackHeight=paneHeight-settings.arrowSize-settings.arrowSize;$track.css({'height':trackHeight+'px',top:settings.arrowSize+'px'})}else{var topArrowHeight=$upArrow.height();settings.arrowSize=topArrowHeight;trackHeight=paneHeight-topArrowHeight-$downArrow.height();$track.css({'height':trackHeight+'px',top:topArrowHeight+'px'})}}
var $pane=jQuery(this).css({'position':'absolute','overflow':'visible'});var currentOffset;var maxY;var mouseWheelMultiplier;var dragPosition=0;var dragMiddle=percentInView*paneHeight/2;var getPos=function(event,c){var p=c=='X'?'Left':'Top';return event['page'+c]||(event['client'+c]+(document.documentElement['scroll'+p]||document.body['scroll'+p]))||0;};var ignoreNativeDrag=function(){return false;};var initDrag=function()
{ceaseAnimation();currentOffset=$drag.offset(false);currentOffset.top-=dragPosition;maxY=trackHeight-$drag[0].offsetHeight;mouseWheelMultiplier=2*settings.wheelSpeed*maxY/contentHeight;};var onStartDrag=function(event)
{initDrag();dragMiddle=getPos(event,'Y')-dragPosition-currentOffset.top;jQuery('html').bind('mouseup',onStopDrag).bind('mousemove',updateScroll);if(jQuery.browser.msie){jQuery('html').bind('dragstart',ignoreNativeDrag).bind('selectstart',ignoreNativeDrag);}
return false;};var onStopDrag=function()
{jQuery('html').unbind('mouseup',onStopDrag).unbind('mousemove',updateScroll);dragMiddle=percentInView*paneHeight/2;if(jQuery.browser.msie){jQuery('html').unbind('dragstart',ignoreNativeDrag).unbind('selectstart',ignoreNativeDrag);}};var positionDrag=function(destY)
{destY=destY<0?0:(destY>maxY?maxY:destY);dragPosition=destY;$drag.css({'top':destY+'px'});var p=destY/maxY;$pane.css({'top':((paneHeight-contentHeight)*p)+'px'});$this.trigger('scroll');if(settings.showArrows){$upArrow[destY==0?'addClass':'removeClass']('disabled');$downArrow[destY==maxY?'addClass':'removeClass']('disabled');}};var updateScroll=function(e)
{positionDrag(getPos(e,'Y')-currentOffset.top-dragMiddle);};var dragH=Math.max(Math.min(percentInView*(paneHeight-settings.arrowSize*2),settings.dragMaxHeight),settings.dragMinHeight);$drag.css({'height':dragH+'px'}).bind('mousedown',onStartDrag);var trackScrollInterval;var trackScrollInc;var trackScrollMousePos;var doTrackScroll=function()
{if(trackScrollInc>8||trackScrollInc%4==0){positionDrag((dragPosition-((dragPosition-trackScrollMousePos)/2)));}
trackScrollInc++;};var onStopTrackClick=function()
{clearInterval(trackScrollInterval);jQuery('html').unbind('mouseup',onStopTrackClick).unbind('mousemove',onTrackMouseMove);};var onTrackMouseMove=function(event)
{trackScrollMousePos=getPos(event,'Y')-currentOffset.top-dragMiddle;};var onTrackClick=function(event)
{initDrag();onTrackMouseMove(event);trackScrollInc=0;jQuery('html').bind('mouseup',onStopTrackClick).bind('mousemove',onTrackMouseMove);trackScrollInterval=setInterval(doTrackScroll,100);doTrackScroll();};$track.bind('mousedown',onTrackClick);if($container.mousewheel){$container.mousewheel(function(event,delta){initDrag();ceaseAnimation();var d=dragPosition;positionDrag(dragPosition-delta*mouseWheelMultiplier);var dragOccured=d!=dragPosition;return!dragOccured;},false);}
var _animateToPosition;var _animateToInterval;function animateToPosition()
{var diff=(_animateToPosition-dragPosition)/settings.animateStep;if(diff>1||diff<-1){positionDrag(dragPosition+diff);}else{positionDrag(_animateToPosition);ceaseAnimation();}}
var ceaseAnimation=function()
{if(_animateToInterval){clearInterval(_animateToInterval);delete _animateToPosition;}};var scrollTo=function(pos,preventAni)
{if(typeof pos=="string"){$e=jQuery(pos,this);if(!$e.length)return;pos=$e.offset().top-$this.offset().top;}
ceaseAnimation();var destDragPosition=-pos/(paneHeight-contentHeight)*maxY;if(!preventAni||settings.animateTo){_animateToPosition=destDragPosition;_animateToInterval=setInterval(animateToPosition,settings.animateInterval);}else{positionDrag(destDragPosition);}};$this[0].scrollTo=scrollTo;$this[0].scrollBy=function(delta)
{var currentPos=-parseInt($pane.css('top'))||0;scrollTo(currentPos+delta);};initDrag();scrollTo(-currentScrollPosition,true);jQuery.jScrollPane.active.push($this[0]);}else{$this.css({'height':paneHeight+'px','width':paneWidth-this.originalSidePaddingTotal+'px','padding':this.originalPadding});}})};jQuery(window).bind('unload',function(){var els=jQuery.jScrollPane.active;for(var i=0;i<els.length;i++){els[i].scrollTo=els[i].scrollBy=null;}});

// @fileRef slidePager.js 
jQuery.fn.extend({slidePager:function(opt){var deflt={easing:'',speed:1000,next:'.next',prev:'.prev',pagernav:'.pagernav',change:false,after:false,links:'a[rel=slide]',last:'',borders:0}
opt=jQuery.extend(deflt,opt);var keeper=jQuery(this),len=!!opt.last?opt.last:keeper.find('.page').length,block=false,curr=0;var rollTo=function(n,clbck){if(!block){block=true;var pos=n*jQuery('.page').attr('offsetWidth')+opt.borders*n;keeper.animate({left:'-'+pos+'px'},opt.speed,opt.easing,function(){block=false;if(opt.after)opt.after(n);})
curr=n;}
jQuery(opt.pagernav).removeClass('active').eq(curr).addClass('active');if(opt.change)opt.change(n);}
var findIdx=function(str){str=str.split('#')[1];var idx=0,tmp;keeper.find('.page').each(function(){if(this.id==str){tmp=idx}
else{idx++}})
return tmp;}
jQuery(opt.next).click(function(){if(curr+1<len)rollTo(curr+1);else rollTo(0);return false;});jQuery(opt.prev).click(function(){if(curr>0)rollTo(curr-1);else rollTo(len-1);return false;});jQuery(document).delegate(opt.links,'click',function(){rollTo(findIdx(this.href));return false;});jQuery(window).resize(function(){rollTo(curr);});}});
