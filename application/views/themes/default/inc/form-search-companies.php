<?$this->load->view('inc/js-meio-mask')?>
<?$this->load->view('inc/js-init-mask')?>

<?=form_open($BC->_getBaseURI()."/search")?>

<table>
<tr>
	<td><?=language('search')?>:</td>
	<td><?=form_input("keywords",trim(urldecode(@$keywords)))?></td>
</tr>

<?load_theme_view('inc/tpl-categories-search-select',array('categories_model'=>'categories'))?>

<tr>
	<td><?=language('sort_by')?>:</td>
	<td><?=form_dropdown("sort_by",array('pub_date'=>language('publish_date'),'name'=>language('thing_name')),$sort_by)?></td>
</tr>
<tr>
	<td><?=language('sort_direction')?>:</td>
	<td><?=form_dropdown("sort_order",array('asc'=>language('ascending'),'desc'=>language('descending')),$sort_order)?></td>
</tr>
</table>

<p><?=form_submit("submit",language('search'));?></p>

</form>

<?$this->load->view('inc/js-selectboxes')?>

<?$this->load->view('inc/js-load-category',array('parent_category'=>0))?>

<script type="text/javascript">

$j(document).ready(function(){
	<?if(!isset($search_category_id)):?>
	load_category(0,false);
	<?endif?>
});

</script>