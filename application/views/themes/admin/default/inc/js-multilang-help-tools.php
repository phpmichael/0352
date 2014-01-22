<script>

$j(document).ready(function()
{
	$j('.multilang-translate').click(function()
	{
		var input = $j(this).parent().find(':input');
		var text = $j(input).val();
		var from_lang = $j(this).attr('rel');
		
		var gtranslate_url = "<?=relative_url($BC->_getBaseURL().'lang/gtranslate')?>";
		
		$j.post(gtranslate_url,{text:text,from_lang:from_lang},function(response)
		{
			<?foreach (get_multilang_codes() as $lang_code):?>
			
			if(from_lang!='<?=$lang_code?>')
			{
				trans_name = input.attr('name').replace("["+from_lang+"]",'[<?=$lang_code?>]');
				
				$j("[name='"+trans_name+"']").val(response.<?=$lang_code?>);
			}
			
			<?endforeach?>
		},'json');
	});
	
	$j('.multilang-copy').click(function()
	{
		var input = $j(this).parent().find(':input');
		var text = $j(input).val();
		var from_lang = $j(this).attr('rel');
		
		<?foreach (get_multilang_codes() as $lang_code):?>
			
		if(from_lang!='<?=$lang_code?>')
		{
			trans_name = input.attr('name').replace("["+from_lang+"]",'[<?=$lang_code?>]');
			
			$j("[name='"+trans_name+"']").val(text);
		}
		
		<?endforeach?>
	});
	
});

</script>