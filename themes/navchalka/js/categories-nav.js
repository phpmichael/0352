function open_level1_node(node)
{
	var recent_level1_node  = $j('li.active-level1-node');
	//unsent recent level1 node
	$j('li.active-level1-node').removeClass('active-level1-node');
	
	var new_level1_node = set_level1_node(node);
	//if different level1 node active then hide recent level1 sub-nodes 
	if(new_level1_node != recent_level1_node) $j(recent_level1_node).find('li').hide();
	//hide all nodes except children of active level1 node
	$j('li.level1 li').hide();
	$j(new_level1_node).find('li').show();
}

function set_level1_node(node)
{
	if( $j(node).hasClass('level1') ) 
	{
		$j(node).addClass('active-level1-node');
		return $j(node);
	}
	else 
	{
		node = $j(node).parent();
		return set_level1_node(node);
	}
	return false;
}

$j(document).ready(function()
{
	$j("#products-categories li a").click(function(e)
	{
		if( $j(this).parent().find('ul').length>0 )
		{
			e.preventDefault();
			open_level1_node($j(this).parent());
		}
	});
});