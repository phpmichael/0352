function activate_tdata(link,url)
{
	if($j(link).hasClass('edit_tdata')) edit_tdata(link);
	else if($j(link).hasClass('view_tdata')) view_tdata(link,url);
}

function edit_tdata(link)
{
	$j(link).html('Save');
	$j(link).removeClass('edit_tdata');
	$j(link).addClass('view_tdata');
	
	var tdata = $j(link).parents('tr').find('td.tdata');
	
	$j.each(tdata, function(i, el) 
	{
		if(!$j(el).hasClass('readonly')) 
		{
			value = $j(el).html();
			id = $j(el).attr('id');
			
			if(id.match(/__id$/i))
			     input = value+"<input name='tdata["+id+"]' id='"+id+"' value='"+value+"' type='hidden' />";
			else if(value.length<=50)
	    		input = "<input name='tdata["+id+"]' id='"+id+"' value='"+htmlspecialchars(value,1)+"' />";
	    	else
	    		input = "<textarea name='tdata["+id+"]' id='"+id+"' style='width:300px;min-height:80px;'>"+htmlspecialchars(value,1)+"</textarea>";
	    	$j(el).html(input);
		}
    });
}

function view_tdata(link,url)
{
	$j(link).html('Saving...');
	
	var tdata = $j(link).parents('tr').find('td.tdata :input');
    //console.log(tdata);
     
    $j.post(url, {tdata:$j(tdata).serialize()}, function( response ) 
    {
        response = $j.parseJSON(response);
        
        //saved
		$j(link).html('Edit');
		$j(link).removeClass('view_tdata');
		$j(link).addClass('edit_tdata');
		
		var replace_code = false;
		var old_code;
		var new_code;
		var new_id;
		
		$j.each(tdata, function(i, el) 
		{
		    id = $j(el).attr('id');
		    tmp = id.split("__");
		    old_code = tmp[0];
		    field = tmp[1];
			old_value = $j(el).val();
			new_value = response[field];
			if(new_value == undefined) new_value = old_value;
			
			if( field == 'code' )
			{
				new_code = response['code'];
				if(old_code != new_code)
				{
					replace_code = true;
				}
			}
			else if(field=='id') new_id = response['id'];
			
	    	$j(el).parent().html(new_value);
	    });
	    
	    //replace code
	    if(replace_code)
	    {
	    	tdata = $j(link).parents('tr').find('td.tdata');
	    	$j.each(tdata, function(i, el) 
	    	{
	    		$j(el).attr('id',$j(el).attr('id').replace(old_code,new_code));
	    	});
	    	$j('a[code='+old_code+']').attr('code',new_code);
	    }
	    
	    //add checkbox for selection
	    $j("#new_checkbox").html('<input type="checkbox" name="check['+new_id+']" value="1">').removeAttr('id');
	    
	    /*if(set_code=='')
		{
		    $j('#'+new_code+'__code').html(new_code);
		}
		
		if(old_code=='NEW')
		{
		    $j(link).remove();
		}*/
		
	});
}

function delete_tdata(link,url)
{
	var code = $j(link).attr('code');
	
	row = $j(link).parents('tr');
	
	$j.post(url, {code:code}, function()
	{
		//deleted
		$j(row).remove();
	});
}