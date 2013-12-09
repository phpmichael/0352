$j(document).ready(
	function () 
	{
	    /* On click submit button */
		$j("#contact_form :input[type='submit']").click(function()
		{
			//Send form						
			$j.post(appPackages.contact_us.form_action, $j("#contact_form").serialize(), function(data) 
			{
				//if message sent successfully
			    if(data=='success') 
				{
					$j("#success").html(appPackages.contact_us.messages.your_message_sent);
					$j("#errors").hide();
					$j("#contact_form").hide();
				}
				//if there are errors
				else $j("#errors").html(data);
			});
			
			return false;	
		});
	}
);