$j(document).ready(
	function () 
	{
		//Hide checking email results
		$j("#check_email").hide();

		/* On Blur email field */
		$j("#registration_form input[name='email']").blur(function()
		{
			//Before Saving
			$j("#check_email").html("Loading...");

			//Check if email exists by ajax request
			$j.post(window.appPackages.customers.check_email_exists_url, $j("#registration_form").serialize(), function(data) 
			{
				$j("#check_email").html(data);
				$j("#check_email").show();
			});

			return false;
		});
	}
);