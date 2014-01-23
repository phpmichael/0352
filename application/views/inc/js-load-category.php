<script>

/*
csb - category selection box
ccl - current categories list
*/

$j(document).ready(function(){
	
	//hide "change" link in view mode (if no form tag)
	if( $j("form").length==0 ) $j(".cs-show-csb").hide();
	
	$j(".cs-show-csb").click(function()
	{
		$j(this).hide();
		$j("#cs-ccl").hide();
		
		$j("#cs-boxes").show();
		$j("#cs-boxes").find(".cs-show-csb").show();
		
		var categories_model = $j(this).attr('model');
		
		var csb_number = $j(".cs-csb").length+1;
		if(csb_number>1 && csb_number>=<?=intval(@$BC->settings_model[$categories_model.'_csb_number'])?>) 
		{
			$j(this).remove();
		}
		
		load_category(<?=$parent_category?>,false,categories_model,csb_number);
	});
});

function load_category( parent_category, select_id, categories_model, csb_number ) 
{
	if(!csb_number) csb_number = 1;
	
	var category_selection_box = $j(".cs-csb[csb="+csb_number+"]");
	
	if($j(category_selection_box).length==0) 
	{
	    $j('<div class="cs-csb" csb="'+csb_number+'"></div>').appendTo("#cs-boxes");
	    category_selection_box = $j(".cs-csb[csb="+csb_number+"]");
	}
	
	//remove all categories selects under current
	if(select_id) $j("#"+select_id).next().nextAll().remove();
	
	//show loading
	$j(category_selection_box).append('<span class="loading"><?=language('loading')?>...</span>');
	
	//make AJAX request
	<?$lang = ($BC->_getInterfaceLang())?$BC->_getInterfaceLang().'/':'';?>
	var url = "<?=relative_url().$lang."categories/get/"?>"+parent_category;
	if(categories_model && categories_model!='undefined') url += '/'+categories_model;
	
	$j.getJSON(url,
        
		function(data)
		{
			$j(".loading",category_selection_box).remove();
			
	        if(data.length !=0 )
	        {
	        	var multi_level = (window.multi_categories_level) ? window.multi_categories_level : 1;//main list always dropdown
				var level = $j("select[id^=category_"+csb_number+"_]",category_selection_box).length;//count of category levels (dropdowns)
	        	
	        	//while level less multi_level show dropdown
				if(!window.multi_categories || level<multi_level) 
				{
					$j(category_selection_box).append("<select name='category[]' id='category_"+csb_number+"_"+parent_category+"' onchange='load_category(this.value,this.id,\""+categories_model+"\",\""+csb_number+"\")'></select>");
					//$j("#category_"+parent_category).addOption(data,false).val(-1);
					
					$j.each(data,function(index,item)
					{
		        		$j("#category_"+csb_number+"_"+parent_category).append("<option value='"+item["category_id"]+"'>"+item["category"]+"</option>");
					});
					
					$j(category_selection_box).append("<br/>");
				}
	        	else
	        	{
	        		$j.each(data,function(index,item)
		        	{
		        		if(item["category_id"]!=-1) $j("<div><input type='checkbox' name='category[]' value="+item["category_id"]+">"+item["category"]+"</div>").appendTo(category_selection_box);
		        	});
	        	}
	        } 
	    }
    
    );

	return false;
}

</script>