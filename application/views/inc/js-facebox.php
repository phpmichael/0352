<?=include_css($BC->_getFolder('js').'jquery/facebox/facebox.css')?>
<script>var FaceBoxPath = "<?=base_url().$BC->_getFolder('js')?>jquery/facebox/";</script>
<?=include_minified($BC->_getFolder('js').'jquery/facebox/facebox.js','js')?>
<script>
//<![CDATA[
$j(document).ready(function(){
	$j("a[rel=facebox]").facebox();
	$j(".close-facebox").live('click',function(){
		$j(document).trigger('close.facebox');
	});
});
//]]>
</script>