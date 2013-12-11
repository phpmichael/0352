$j(document).ready(
	function () 
	{
		/* Set rating */
		$j(".rating a").click(function()
		{
			var rating = 0;
			
			if( $j(this).hasClass('rating-inc') )
			{
				rating = 1;
			}
			else
			{
				rating = -1;
			}
			
			var post_id = $j(this).attr('id').substring(11).replace(/[^0-9]/g,'');
			var table = $j(this).attr('rel');
			
			setRating(table,post_id,rating);
		});
	}
);

//Set rating for post
function setRating(table,post_id,rating)
{					
	$j("#rating-inc-"+post_id+"-"+table).hide();
	$j("#rating-dec-"+post_id+"-"+table).hide();
    
    $j.post(appPackages.ratings.form_action, {table:table,post_id:post_id,rating:rating}, function(data) //set rating by ajax request
    {
		data = $j.parseJSON(data);
		
		if(data.error==0) 
		{
			$j("#rating-val-"+post_id+"-"+table).html(data.rating);
		}
		else 
		{
		    alert(data.error);
		}
	});
}