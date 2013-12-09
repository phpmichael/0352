<div class="red"><?=validation_errors()?></div>

<form action="" method="post">

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?></td>
</tr>
<?load_theme_view('inc/tpl-categories-view-and-select',array('categories_model'=>'photos_categories'))?>
</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>

<?$this->load->view('inc/js-selectboxes')?>
<?$this->load->view('inc/js-load-category',array('parent_category'=>0))?>

<script type="text/javascript">

$j(document).ready(function(){
	<?if(!isset($post_categories)):?>
	load_category(0,false,'photos_categories');
	<?endif?>
});

</script>