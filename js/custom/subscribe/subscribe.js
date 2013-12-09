$j(document).ready(
	function () 
	{
		$j("#subscribe_email").click(function()
		{
			if( $j(this).val()=='E-Mail' ) $j(this).val('');
		});
		
		/* On click subscribe button */
		$j("#subscribe").click(function()
		{
			//Send form						
			$j.post(appPackages.subscribe.form_action, $j("#subscribe_form").serialize(), function(data) 
			{
				$j("#subscribe_results").html(data);
			});
			
			return false;	
		});
	}
);