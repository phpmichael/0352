<?=include_css($BC->_getFolder('js').'jquery/lightbox/css/jquery.lightbox-0.5.css')?>
<script type="text/javascript">var LightBoxPath = "<?=base_url().$BC->_getFolder('js')?>jquery/lightbox/";</script> 
<?=include_js($BC->_getFolder('js').'jquery/lightbox/js/jquery.lightbox-0.5.js')?>
<script type="text/javascript">
//<![CDATA[
$j(function() 
{
	$j('a.product-image, a.lightbox, a[rel=lightbox]').lightBox();
});
//]]>
</script>