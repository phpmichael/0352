<?=include_js($BC->_getFolder('js').'jquery/mylib/jquery.check.js')?>
<script>
    $j(document).ready(
	    function () 
	    {
	    	/* Select Row */
	    	$j("input[name^='check']").bind("click", {}, toggleTableRow);
	    }
    );
    
    function toggleTableRow()
    {
    	if(this.checked) $j(this).parents().addClass('selected');
    	else $j(this).parents().removeClass('selected');
    }
    
    function ToggleAll()
    {
    	$j("input[name^='check']").check('toggle');
    	$j("input[name^='check']").each(toggleTableRow);
    }
</script>