$j(document).ready(
	function () 
	{
		$j("#subscribe_email").click(function()
		{
			if( $j(this).val()=='E-Mail' ) $j(this).val('');
		});
		
		/* On click subscribe button */
		$j("#unsubscribe").click(function()
		{
			//Send form						
			$j.post(appPackages.subscribe.form_action_unsubscribe, $j("#unsubscribe_form").serialize(), function(data) 
			{
				$j("#subscribe_results").html(data);
			});
			
			return false;	
		});
	}
);