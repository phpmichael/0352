<script>
//<![CDATA[
$j(document).ready(function()
{
    $j("#poll-form").submit(function()
    {
        var url = $j(this).attr('action');
        var answer = $j("#poll-form input[name=answer]:checked").val();
        
        if(!answer) 
        {
            alert('<?=language('please_select_answer')?>');
            return false;
        }
        
        $j.post(url,{answer:answer},function(response)
        {
            if(response.result=='success')
            {
                alert(response.message);
                
                var results_url = '<?=poll_results_url($poll_data)?>';
                
                $j("#poll-form").parent().load(results_url);
            }
            else
            {
                alert(response.message);
            }
        },'json');
        
        return false;
    });
});
//]]>
</script>