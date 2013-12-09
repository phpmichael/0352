$j(document).ready(
	function () 
	{
		/* On click submit button */
		$j("#commentform input[type='submit']").click(function()
		{
		    $j("#ca").val(1);

			//Send form						
			$j.post(appPackages.comments.form_action, $j("#commentform").serialize(), function(data) 
			{
				if(data=='success') 
				{
					$j("#success").html(window.success_message);
					$j("#errors").html('');
					$j("#commentform").hide();
					$j("#comment_content").val('');
				}
				else 
				{
				    $j("#errors").html(data);
                    $j("#success").html('');
				}
			});
			
			return false;	
		});
	}
);

if ( typeof CommentOnComment != "function" )
{
	//Respond on user's comment
    function CommentOnComment(parent_id)
	{
		$j("#success").html('');
		$j("#errors").html('');
	    
	    //set id of parent comment //0 for regular comment
		$j("#parent_id").val(parent_id);
		//display comment form
		$j("#commentform").show();
		//go to add-comment anchor
		window.location.hash='add-comment';
	}
}