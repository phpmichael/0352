<div class="red"><?=validation_errors()?></div>

<form action="" method="post" enctype="multipart/form-data">

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?></td>
</tr>

<?load_theme_view('inc/tpl-categories-view-and-select',array('categories_model'=>'categories'))?>

<tr>
	<td><?=$BC->_getFieldTitle("name")?>: <span class="red">*</span></td>
	<td><?=form_input("name",set_value('name',@$name),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("email")?>:</td>
	<td><?=form_input("email",set_value('email',@$email),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("phone")?>: </td>
	<td><?=form_input("phone",set_value('phone',@$phone),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("phone2")?>: </td>
	<td><?=form_input("phone2",set_value('phone2',@$phone2),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("fax")?>: </td>
	<td><?=form_input("fax",set_value('fax',@$fax),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("website")?>: </td>
	<td><?=form_input("website",set_value('website',@$website),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("city")?>: </td>
	<td><?=form_input("city",set_value('city',@$city),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("region")?>: </td>
	<td><?=form_input("region",set_value('region',@$region),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("address")?>: </td>
	<td><?=form_input("address",set_value('address',@$address),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("work_time")?>: </td>
	<td><?=form_input("work_time",set_value('work_time',@$work_time),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("short_description")?>: </td>
	<td><?=form_textarea("short_description",set_value('short_description',@$short_description),"class='textarea'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("services")?>: </td>
	<td><?=form_textarea("services",set_value('services',@$services),"class='textarea'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("long_description")?>: </td>
	<td><?=form_textarea("long_description",set_value('long_description',@$long_description),"class='textarea'");?></td>
</tr>
<?if(@$image):?>
<tr>
	<td><a href="<?=base_url().'images/data/b/companies/'.$image?>" rel="facebox"><?=img('images/data/s/companies/'.$image."?no_cache=".time())?></a></td>
	<td><?=anchor_admin("deleteimage",$id)?></td>
</tr>
<?endif?>
<tr>
	<td><?if(@$image):?><?=language('change')?><?else:?><?=language('add')?><?endif?> <?=language('image')?>:</td>
	<td><?=form_upload("image")?> <br />(<?=language('file_in_jpg_or_png_format')?>, <?=language('filesize_2mb_max')?>)</td>
</tr>

<?load_theme_view('inc/tpl-additional-images'); ?>

</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>

<?$this->load->view('inc/js-selectboxes')?>
<?$this->load->view('inc/js-load-category',array('parent_category'=>0))?>

<script>

var multi_categories = true;
var multi_categories_level = <?=intval(@$BC->settings_model['companies_categories_multi_level'])?>;

$j(document).ready(function(){
	<?if(!isset($post_categories)):?>
	load_category(0,false);
	<?endif?>
});

</script>

<?$this->load->view('inc/js-facebox'); ?>