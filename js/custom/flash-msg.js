function show_flash_msg(msg, css_class, parent_id, hide_me, hide_other)
{
	if( hide_other ) $j(".flash-msg").hide();
	
	flash_msg_div = $j("<div class='flash-msg "+css_class+"'><p>"+msg+"</p></div>").prependTo( $j("#"+parent_id) );
	
	if( hide_me ) setTimeout(function(){ hide_flash_msg( $j(flash_msg_div).find('p'), 1000 );  }, 3000);
}

function hide_flash_msg(flash_msg_p,timeout)
{
	$j(flash_msg_p).fadeOut(timeout);
}

$j(document).ready(function() {
    //hide message on click
	$j(".red p, .error p, .success p").live('click',function () 
	{
		hide_flash_msg(this, 1000);
	});
});