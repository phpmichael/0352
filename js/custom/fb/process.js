$j(document).ready(function()
{
    FB = {
        form : $j(".fb-output-screen form:first")
    }
    
    //click on remove file link
    $j("a.remove-file",FB.form).click(function(){
        var element = this;
        
        $j.get($j(element).attr('href'),{},function(){
            $j(element).parent().remove();
        });
        
        return false;
    });
    
    //hilight focused inputs
    $j("input,select,textarea",FB.form).click(function(){
		$j(".focused").removeClass('focused');
		$j(this).parents('li:first').addClass('focused');
	});
	
	//skip rules
	run_skip_rules();
	
	$j("select",FB.form).change(function(){
	    run_skip_rules();
	});
	
	$j("input[type=radio],input[type=checkbox]",FB.form).click(function(){
		run_skip_rules();
	});
	
});

function run_skip_rules()
{
    FD = { 
        dataKey: $j(FB.form).attr('data_key')
    };
    
    //$j(":input[name!='']").not("[name$=']']").not('textarea').each(function(){//don't take textareas and inputs with "[]" (arrays)
    $j("select,input[type=radio]:checked,input[type=checkbox]",FB.form).not("[name='']").not("[name$=']']").each(function(){
    	
    	//console.log($j(this).attr('name'));
    	
    	if( $j(this).attr('type') == 'checkbox' && !$j(this).attr('checked') )
    	{
    		_js = 'FD.' + $j(this).attr('name') + ' = "" ';
    	}
    	else 
    	{
    		value = ($j(this).val())?$j(this).val():'';
    		_js = 'FD.' + $j(this).attr('name') + ' = "' + value.replace(/"/g,'\\"') + '"'; //" just for correct hilight in Zend Studio
    	}
        
    	//console.log(_js);
        
        try 
        {
            eval( _js );
        } 
        catch (error) 
        {
            if ( typeof(console) != "undefined" ) 
            {
                console.log(_js);
                console.log(error);
            }
        }
        
    });
    
    $j("li[skip_rule]",FB.form).each(function(){
        
        _js = "_hideElement = (" + $j(this).attr('skip_rule') + ")";
        //console.log(_js);
        
        try 
        {
            eval( _js );
        } 
        catch (error) 
        {
            if ( typeof(console) != "undefined" ) 
            {
                console.log(_js);
                console.log(error);
            }
            
            _hideElement = false;
        }
        
        if( _hideElement ) 
        {
            //unset values
            $j(this).find(":checked").removeAttr("checked");
            $j(this).find("input[type=text],input[type=password],textarea").val('');
            //set selected index=1 for select
            $j(this).find("select").find('option:selected').removeAttr("selected");
			$j(this).find("select").find('option:first').attr("selected",true);
            
            $j(this).hide();
            
            //disable inputs
            //$j(this).find(":input").attr("disabled","disabled");
        }
        else 
        {
        	$j(this).show();
        	
        	//enable inputs
            //$j(this).find(":input").removeAttr("disabled");
        }
    });
}