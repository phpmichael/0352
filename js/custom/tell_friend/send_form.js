$j(document).ready(
	function () 
	{
		/* On click submit button */
		$j("#tell_friend_form :input[type='submit']").click(function()
		{
			//Send form					
			$j.post(appPackages.tell_friend.form_action, $j("#tell_friend_form").serialize(), function(data) 
			{
				//if message sent successfully
			    if(data=='success') 
				{
					$j("#success").html(appPackages.tell_friend.messages.your_message_sent);
					$j("#errors").hide();
					$j("#tell_friend_form").hide();
				}
				//if there are errors
				else $j("#errors").html(data);
			});
			
			return false;	
		});
	}
);