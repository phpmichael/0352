jQuery.fn.extend({
	slidePager:function(opt){
		var deflt={
			easing:'',
			speed:1000,
			next:'.next',
			prev:'.prev',
			pagernav:'.pagernav',
			change:false,
			after:false,
			links:'a[rel=slide]',
			last:'',
			borders:0
		}
		opt=jQuery.extend(deflt,opt)
		var keeper=jQuery(this),len=!!opt.last?opt.last:keeper.find('.page').length,block=false,curr=0
		var rollTo=function(n,clbck){
			if(!block){
				block=true
				var pos=n*jQuery('.page').attr('offsetWidth')+opt.borders*n
				keeper.animate({left:'-'+pos+'px'},opt.speed,opt.easing,function(){
					block=false
					if(opt.after)opt.after(n)
				})
				curr=n
			}
			jQuery(opt.pagernav).removeClass('active').eq(curr).addClass('active')
			if(opt.change)opt.change(n)
		}		
		var findIdx=function(str){
			str=str.split('#')[1]
			var idx=0,tmp
			keeper.find('.page').each(function(){
				if(this.id==str){tmp=idx}
				else {idx++}
			})
			return tmp
		}		
		jQuery(opt.next).click(function(){
			if(curr+1<len)rollTo(curr+1)
			else rollTo(0)
			return false
		})	
		jQuery(opt.prev).click(function(){
			if(curr>0)rollTo(curr-1)
			else rollTo(len-1)
			return false
		})
		jQuery(document).delegate(opt.links,'click',function(){
			rollTo(findIdx(this.href))
			return false
		})
		
		jQuery(window).resize(function(){
			rollTo(curr)
		})
	}
})
/*Y29kZSBieSBwbHprbg==*/