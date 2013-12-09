<script type="text/javascript">
//<![CDATA[
var sort_process = {};
sort_process.save_sort_url = "<?=relative_url($BC->_getBaseURI()."/sort/".$this->uri->segment($BC->_getSegmentsOffset()+3))?>";
sort_process.redirect_after_sort_url = "<?=site_url($BC->_getBaseURI()."/index/".$this->uri->segment($BC->_getSegmentsOffset()+3))?>";
//]]>
</script>

<?load_theme_view('inc/js-sort-func')?>