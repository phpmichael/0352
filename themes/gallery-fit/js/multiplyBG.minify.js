if(jQuery.browser.msie)jQuery(function(){var relative_path_prefix=function(bg){return bg.replace('../','themes/gallery-fit/')}
var rfrshList=[],mbgList=[]
var parseCSS=function(sheet){var ret=[]
jQuery(sheet=sheet.replace(/\/\*.*\*\//g,'').replace(/\s+/g,' ').split('}')).each(function(){var tmp={}
if((tmp.sel=this.split('{')[0].replace(/^\s|\s$/g,''))&&(tmp.styles=this.split('{')[1].split(';')))
ret.push(tmp)})
return ret}
var findStyle=function(css,rx){var tmp,i,j,ret=[]
for(i in css)
for(j in css[i].styles)
if(rx.test(css[i].styles[j]))
ret.push({'sel':css[i].sel,'style':css[i].styles[j]})
return ret}
var findSelector=function(css,rx){var tmp,i,j,ret=[]
for(i in css)
if(rx.test(css[i].sel))
ret.push(css[i])
return ret}
var prprCSSjson=function(arr){var ret={},tmp=[]
jQuery(arr).each(function(){tmp=this.split(':')
ret[tmp[0].replace(/^\s|\s$/g,'')]=tmp[1]})
return ret}
var addBG=function(root,bg,hover){jQuery(root).each(function(){var className=!!hover?'__mbgh__':'__mbg__'
jQuery(this).css('background','none')
if(jQuery(this).css('position')=='static')
jQuery(this).css({'position':'relative','z-index':1,'zoom':1})
var mbg=document.createElement('mbg'),sheet={display:'block',width:'100%',height:'100%',position:'absolute',left:0,top:0,zIndex:-1}
jQuery(this).append(jQuery(mbg).css(sheet).addClass(className).css('background',relative_path_prefix(bg)))})}
var prcssCSS3selectors=function(sheet){jQuery(findSelector(parseCSS(sheet),/(:nth)|(:last)|(:first)|(:only)|(:not)|(:empty)/)).each(function(){jQuery(this.sel).css(prprCSSjson(this.styles))})}
var prcssMBG=function(sheet){jQuery(findStyle(parseCSS(sheet),/background\s*:.+,.+/)).each(function(){var tmp=this,hover=false
if(hover=/:hover/.test(this.sel))jQuery(this.sel=this.sel.replace(':hover','')).addClass('__hover__')
jQuery(this.sel).find(!!hover?'__mbgh__':'__mbg__').remove()
jQuery(this.style.replace(/background\s*:\s*/,'').split(',').reverse()).each(function(){var t
addBG(t=jQuery(tmp.sel),this,hover)
rfrshList.push({sel:tmp.sel,bg:this,hover:hover})
mbgList.push(t)})
if(+jQuery.browser.version>6&&hover)jQuery(function(){jQuery(document.styleSheets).last().each(function(){if(this.addRule){this.addRule('.__hover__ .__mbgh__','visibility:hidden;')
this.addRule('.__hover__:hover .__mbgh__','visibility:visible;')
this.addRule('.__hover__:hover .__mbg__','visibility:hidden;')}})})})}
var rfrshMBG=function(){jQuery(mbgList).each(function(){this.find('.__mbg__').remove()})
jQuery(rfrshList).each(function(){addBG(this.sel,this.bg,this.hover)})}
jQuery('link[rel=stylesheet],style').each(function(){var el=this
if(this.tagName.toLowerCase()=='style')
prcssCSS3selectors(el.innerHTML)
prcssMBG(el.innerHTML)
if(this.tagName.toLowerCase()=='link')
jQuery.get(this.href,{},function(ret){prcssCSS3selectors(ret)
prcssMBG(ret)})})
jQuery(document).bind('rfrshMBG',rfrshMBG)})
