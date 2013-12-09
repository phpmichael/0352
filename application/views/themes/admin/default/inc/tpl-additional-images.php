<?if(!empty($additional_images)):?>
<tr>
	<td><?=language('images')?>:</td>
	<td>
	<?foreach ($additional_images as $additional_image):?>
	   <div style="float:left">
	       <a href="<?=base_url().'images/data/b/'.$BC->_getCurrentTable().'/'.$additional_image['image']?>" rel="facebox"><?=img('images/data/s/'.$BC->_getCurrentTable().'/'.$additional_image['image'])?></a>
	       <br/>
	       <?=anchor_admin("delete_additional_image",$id,'/'.$additional_image['id'])?>
	   </div>
	<?endforeach?>
	</td>
</tr>
<?endif?>

<tr>
	<td></td>
	<td><a href="javascript:void(0);" onclick="$j('.additional_image').show()"><?=language('more_images')?></a></td>
</tr>
<tr class="additional_image" style="display:none;">
	<td><?=language('add')?> <?=language('image')?>:</td>
	<td><?=form_upload("image_1")?></td>
</tr>
<tr class="additional_image" style="display:none;">
	<td><?=language('add')?> <?=language('image')?>:</td>
	<td><?=form_upload("image_2")?></td>
</tr>
<tr class="additional_image" style="display:none;">
	<td><?=language('add')?> <?=language('image')?>:</td>
	<td><?=form_upload("image_3")?></td>
</tr>