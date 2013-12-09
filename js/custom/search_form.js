function hide_search_form()
{
	$j("#search_from").hide();
	$j("#search_creteria").show();
}

function show_search_form()
{
	$j("#search_from").show();
	$j("#search_creteria").hide();
}

$j(document).ready(function()
{
    if(window.hidden_search_form) hide_search_form();
	
	$j("#search_creteria").click(function()
	{
		show_search_form();
	});
	
});