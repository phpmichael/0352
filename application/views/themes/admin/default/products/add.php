<div class="red"><?=validation_errors()?></div>

<form action="" method="post" enctype="multipart/form-data">

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?>.</td>
</tr>

<?load_theme_view('inc/tpl-categories-view-and-select',array('categories_model'=>'products_categories'))?>

<?if(@$BC->settings_model['use_product_sku']):?>
<tr>
	<td><?=$BC->_getFieldTitle("SKU")?>: <span class="red">*</span></td>
	<td><?=form_input("SKU",set_value('SKU',@$SKU));?></td>
</tr>
<?endif?>

<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("name")?> (<?=$lang_code?>): <span class="red">*</span></td>
	<td><?=form_input("name[{$lang_code}]",set_value("name[{$lang_code}]",@$name[$lang_code]),"class='largeinput'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>

<tr>
	<td colspan="2"><a href="javascript:void(0);" class="showhide_metadata"><?=language('showhide_metadata')?></a></td>
</tr>

<?foreach (get_multilang_codes() as $lang_code):?>
<tr class="hide">
	<td width="150"><?=$BC->_getFieldTitle("page_title")?> (<?=$lang_code?>):</td>
	<td><?=form_input("page_title[{$lang_code}]",set_value("page_title[{$lang_code}]",@$page_title[$lang_code]),"class='meta largeinput'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr class="hide">
	<td width="150"><?=$BC->_getFieldTitle("meta_keywords")?> (<?=$lang_code?>):</td>
	<td><?=form_input("meta_keywords[{$lang_code}]",set_value("meta_keywords[{$lang_code}]",@$meta_keywords[$lang_code]),"class='largeinput'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr class="hide">
	<td width="150"><?=$BC->_getFieldTitle("meta_description")?> (<?=$lang_code?>):</td>
	<td><?=form_input("meta_description[{$lang_code}]",set_value("meta_description[{$lang_code}]",@$meta_description[$lang_code]),"class='largeinput'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>

<tr>
	<td><?=$BC->_getFieldTitle("price")?>: <span class="red">*</span></td>
	<td>
	   <?=form_input("price",set_value('price',@$price));?> 
	   <a href="javascript:void(0);" onclick="$j('input[name=old_price]').toggle();"><?=language('old_price')?></a>
	   <?=form_input("old_price",set_value('old_price',@$old_price),(@$old_price!=0.00)?"":"style='display:none'");?> 
	</td>
</tr>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td><?=$BC->_getFieldTitle("description")?> (<?=$lang_code?>):</td>
	<td><?=form_textarea("description[{$lang_code}]",set_value("description[{$lang_code}]",@$description[$lang_code]),"class='richtext'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("youtube_url")?>:</td>
	<td><?=form_input("youtube_url",set_value('youtube_url',@$youtube_url),"class='largeinput'");?> (http://www.youtube.com/watch?v=XXXXXXXXXXX)</td>
</tr>
<?if(@$image):?>
<tr>
	<td><a href="<?=base_url().'images/data/b/products/'.$image?>" rel="facebox"><?=img('images/data/s/products/'.$image)?></a></td>
	<td><?=anchor_admin("deleteimage",$id)?></td>
</tr>
<?endif?>
<tr>
	<td><?if(@$image):?><?=language('change')?><?else:?><?=language('add')?><?endif?> <?=language('image')?>:
	   <br /><br /><a href="javascript:void(0);" onclick="$j('.alt_attr').toggle();"><?=language('add_alt_attribute_for_image')?></a>
	</td>
	<td><?=form_upload("image")?> <br />(<?=language('file_in_jpg_or_png_format')?>, <?=language('filesize_2mb_max')?>)</td>
</tr>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr class="alt_attr" style="display:none;">
	<td width="150"><?=$BC->_getFieldTitle("alt")?> (<?=$lang_code?>):</td>
	<td><?=form_input("alt[{$lang_code}]",set_value("alt[{$lang_code}]",@$alt[$lang_code]),"class='largeinput'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>

<?load_theme_view('inc/tpl-additional-images'); ?>

<?if(userAccess('products_manufacturers','edit')):?>
<!-- Manufacturer -->
<tr>
	<td><?=$BC->_getFieldTitle("manufacturer_id")?>:</td>
	<td><?=form_dropdown("manufacturer_id",$BC->products_manufacturers_model->getManufacturersList(),set_value('manufacturer_id',@$manufacturer_id));?></td>
</tr>
<?endif?>

<?if(userAccess('products_attributes','edit')):?>
<!-- Attributes -->
<tr>
	<td colspan="2"><b><?=language('products_attributes')?></b></td>
</tr>
<?foreach ($BC->products_attributes_model->getAvailableAttributesList() as $attr_id=>$attr_name):?>
<tr>
	<td><?=$attr_name?></td>
	<td>
		<?foreach ($BC->products_attributes_model->getAvailableValuesList($attr_id) as $attr_value_id=>$attr_value):?>
			<?=form_checkbox('products_attributes['.$attr_id.'][]',$attr_value_id,@in_array($attr_value_id,array_keys((array)$attributes_list[$attr_id]['values'])))?> <?=$attr_value?>
		<?endforeach?>
	</td>
</tr>
<?endforeach?>
<?endif?>

</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>

<?=load_inline_js('inc/js-tinymce')?>

<?=load_inline_js('inc/js-selectboxes')?>
<?=load_inline_js('inc/js-load-category',array('parent_category'=>0))?>

<script>
var multi_categories = true;
var multi_categories_level = <?=intval(@$BC->settings_model['products_categories_multi_level'])?>;

$j(document).ready(function(){
	<?if(!isset($post_categories)):?>
	load_category(0,false,"products_categories");
	<?endif?>
});
</script>

<?load_theme_view('inc/js-multilang-help-tools')?>

<?load_theme_view('inc/js-showhide-metadata')?>

<?=load_inline_js('inc/js-facebox'); ?>