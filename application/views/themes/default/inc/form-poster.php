<div class="red"><?=validation_errors()?></div>

<form action="" method="post" enctype="multipart/form-data">

<?if(@$id):?>
	<?=form_hidden('id',$id)?>
<?endif?>

<table>
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?>.</td>
</tr>

<?load_theme_view('inc/tpl-categories-view-and-select',array('categories_model'=>'categories'))?>

<tr>
	<td colspan="2" class="vt"><?=$BC->_getFieldTitle("title")?>: <span class="red">*</span></td>
</tr>
<tr>
	<td colspan="2">
		<?=form_textarea("title",set_value('title',@$title),"class='title'");?>
		<br /> <small>(<?=language('max_255_chars')?>)</small>
	</td>
</tr>
<tr>
	<td colspan="2"><?=$BC->_getFieldTitle("text")?>: <span class="red">*</span></td>
</tr>
<tr>
	<td colspan="2"><?=form_textarea("text",set_value('text',@$text));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("period")?>:</td>
	<td><?=form_dropdown("period",array(30=>'1 '.language('month'),60=>'2 '.language('months'),90=>'3 '.language('months'),180=>'6 '.language('months1')),set_value('period',@$period))?></td>
</tr>
<?if(@$image):?>
<tr>
	<td><?=img('images/data/s/posters/'.$image."?no_cache=".time())?></td>
	<td><?=anchor_base('posters/deleteimage/'.$id,language('delete'))?></td>
</tr>
<?endif?>
<tr>
	<td><?if(@$image):?><?=language('change')?><?else:?><?=language('add')?><?endif?> <?=language('image')?>:</td>
	<td><?=form_upload("image")?> <br />(<?=language('file_in_jpg_or_png_format')?>, <?=language('filesize_2mb_max')?>)</td>
</tr>
</table>

<p><?=form_submit("submit",language('save'))?></p>

</form>