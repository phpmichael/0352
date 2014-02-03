$j(document).ready(
	function () 
	{
		//process "request a call" click
	    $j(".request-call").click(function(){
            var url = appPackages.request_call.content_url;
    		title = appPackages.request_call.title;
    	    
    	    $j.get(url,{},function(response){
    			  
    		    text = response;
    		    
    		    buttons = 
    			   {
    					"Submit": function() { 
    						
                			//Send form					
                			$j.post(appPackages.request_call.form_action, $j("#request_call_form").serialize(), function(data) 
                			{
                				//if message sent successfully
                			    if(data=='success') 
                				{
                					$j("#request_call .success").html(appPackages.request_call.messages.sent);
                					$j("#request_call .errors").hide();
                					$j("#request_call_form").hide();
                				}
                				//if there are errors
                				else $j("#request_call .errors").html(data);
                			});
                			
                			return false;
    					},
    			        "Close": function() { 
    						$j(this).dialog("close");
    					}
    				}
    			
    			dialog(title,text,buttons,320);  
    		});
		});
	}
);