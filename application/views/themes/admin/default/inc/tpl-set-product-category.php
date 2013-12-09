<table width="100%">
<?load_theme_view('inc/tpl-categories-view-and-select',array('categories_model'=>'products_categories'))?>
</table>
<?$this->load->view('inc/js-selectboxes')?>
<?$this->load->view('inc/js-load-category',array('parent_category'=>0))?>

<script type="text/javascript">
//<![CDATA[
var multi_categories = true;
var multi_categories_level = <?=intval(@$BC->settings_model['products_categories_multi_level'])?>;

$j(document).ready(function(){
	<?if(!isset($post_categories)):?>
	load_category(0,false,"products_categories");
	<?endif?>
});
//]]>
</script>