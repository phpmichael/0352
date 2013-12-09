<div id="ajax_response"></div>

<?=form_open()?>

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?>.</td>
</tr>
<?//label?>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("label")?> (<?=$lang_code?>): <span class="red">*</span></td>
	<td><?=form_input("label[{$lang_code}]",set_value("label[{$lang_code}]",@$label[$lang_code]),"class='largeinput'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>
<?//name?>
<tr <?if(in_array(@$type,array('content'))):?>style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("name")?>: </td>
	<td><?=form_input("name",set_value('name',@$name),"class='largeinput'");?> <a href="javascript:void(0)" class="generate-from-en-label">&lt <?=language('label')?> (EN)</a></td>
</tr>
<?//html id?>
<tr <?if(in_array(@$type,array('content','hidden','display'))):?>style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("html_id")?>:</td>
	<td><?=form_input("html_id",set_value('html_id',@$html_id));?></td>
</tr>
<?//type?>
<tr>
	<td><?=$BC->_getFieldTitle("type")?>: <span class="red">*</span></td>
	<td>
		<?=form_dropdown("type",array('text'=>'text','password'=>'password','select'=>'select','textarea'=>'textarea','radio'=>'radio','checkbox'=>'checkbox','submit'=>'submit','captcha'=>'captcha','richtext'=>'richtext','file'=>'file','date'=>'date','time'=>'time','content'=>'content','display'=>'display','hidden'=>'hidden'),set_value('type',@$type));?>
		<?if(@$answerset_id): $answerset = $BC->formbuilder_model->getAnswersetById($answerset_id)?><a href="javascript:void(0)" class="attached-answerset" answerset_id="<?=$answerset_id?>"><?=$answerset['label'][strtoupper($BC->_getInterfaceLang(TRUE))]?></a><?endif?>
	</td>
</tr>
<?//default value?>
<tr <?if(in_array(@$type,array('password','submit','captcha','file','content'))):?>style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("default_value")?>:</td>
	<td><?=form_input("value",set_value('value',@$value));?></td>
</tr>
<?//validation?>
<tr <?if(in_array(@$type,array('submit','content','display'))):?>style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("validation")?>:</td>
	<td><?=form_input("validation",set_value('validation',@$validation),"class='largeinput'");?></td>
</tr>
<?//show on list?>
<tr <?if(in_array(@$type,array('submit','content'))):?>style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("show_on_list")?>: <span class="red">*</span></td>
	<td><?=form_dropdown("show_on_list",array('no'=>language('no'),'yes'=>language('yes')),set_value('show_on_list',@$show_on_list),"style='width:50px;'");?></td>
</tr>
<?//align?>
<tr <?if(in_array(@$type,array('hidden'))):?>style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("align")?>: <span class="red">*</span></td>
	<td><?=form_dropdown("align",array('left'=>'left','right'=>'right','center'=>'center'),set_value('align',@$align),"style='width:90px;'");?></td>
</tr>
<?//hint?>
<tr <?if(in_array(@$type,array('submit','checkbox','radio','content','hidden'))):?>style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("hint")?>:</td>
	<td><?=form_input("hint",set_value('hint',@$hint),"class='largeinput'");?></td>
</tr>
<?//height?>
<tr <?if(in_array(@$type,array('radio','checkbox','submit','content','hidden','display'))):?>style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("height")?>:</td>
	<td><?=form_input("height",set_value('height',@$height),"style='width:40px;'");?> <?=form_dropdown("height_units",array('px'=>'px','%'=>'%'),set_value('height_units',@$height_units),"style='width:50px;'");?></td>
</tr>
<?//width?>
<tr <?if(in_array(@$type,array('radio','checkbox','submit','content','hidden','display'))):?>style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("width")?>:</td>
	<td><?=form_input("width",set_value('width',@$width),"style='width:40px;'");?> <?=form_dropdown("width_units",array('px'=>'px','%'=>'%'),set_value('width_units',@$width_units),"style='width:50px;'");?></td>
</tr>
<?//label position?>
<tr <?if(in_array(@$type,array('submit','content','hidden'))):?>style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("label_position")?>: <span class="red">*</span></td>
	<td><?=form_dropdown("label_position",array('left'=>'left','right'=>'right','top'=>'top'),set_value('label_position',@$label_position),"style='width:90px;'");?></td>
</tr>
<?//label align?>
<tr <?if(in_array(@$type,array('submit','content','hidden'))):?>style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("label_align")?>: <span class="red">*</span></td>
	<td><?=form_dropdown("label_align",array('left'=>'left','right'=>'right','center'=>'center'),set_value('label_align',@$label_align),"style='width:90px;'");?></td>
</tr>
<?//hide label?>
<tr <?if(in_array(@$type,array('submit','content','hidden'))):?>style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("hide_label")?>: <span class="red">*</span></td>
	<td><?=form_dropdown("hide_label",array('no'=>language('no'),'yes'=>language('yes')),set_value('hide_label',@$hide_label),"style='width:50px;'");?></td>
</tr>
<?//html class?>
<tr <?if(in_array(@$type,array('hidden'))):?>style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("html_class")?>:</td>
	<td><?=form_input("html_class",set_value('html_class',@$html_class));?></td>
</tr>
<?//skip rule?>
<tr>
	<td><?=$BC->_getFieldTitle("skip_rule")?>:</td>
	<td><?=form_input("skip_rule",set_value('skip_rule',@$skip_rule));?></td>
</tr>


<?//inputs for image?>
<?//small height?>
<tr <?if(!in_array(@$type,array('file'))):?>style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("image_small_height")?>:</td>
	<td><?=form_input("image_small_height",set_value('image_small_height',@$image_small_height),"style='width:40px;'");?> px</td>
</tr>
<?//small width?>
<tr <?if(!in_array(@$type,array('file'))):?>style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("image_small_width")?>:</td>
	<td><?=form_input("image_small_width",set_value('image_small_width',@$image_small_width),"style='width:40px;'");?> px</td>
</tr>
<?//small crop?>
<tr <?if(!in_array(@$type,array('file'))):?>style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("image_small_crop")?>:</td>
	<td><?=form_dropdown("image_small_crop",array(0=>language('no'),1=>language('yes')),set_value('image_small_crop',@$image_small_crop),"style='width:50px;'");?></td>
</tr>
<?//medium height?>
<tr <?if(!in_array(@$type,array('file'))):?>style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("image_medium_height")?>:</td>
	<td><?=form_input("image_medium_height",set_value('image_medium_height',@$image_medium_height),"style='width:40px;'");?> px</td>
</tr>
<?//medium width?>
<tr <?if(!in_array(@$type,array('file'))):?>style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("image_medium_width")?>:</td>
	<td><?=form_input("image_medium_width",set_value('image_medium_width',@$image_medium_width),"style='width:40px;'");?> px</td>
</tr>
<?//medium crop?>
<tr <?if(!in_array(@$type,array('file'))):?>style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("image_medium_crop")?>:</td>
	<td><?=form_dropdown("image_medium_crop",array(0=>language('no'),1=>language('yes')),set_value('image_medium_crop',@$image_medium_crop),"style='width:50px;'");?></td>
</tr>
<?//big height?>
<tr <?if(!in_array(@$type,array('file'))):?>style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("image_big_height")?>:</td>
	<td><?=form_input("image_big_height",set_value('image_big_height',@$image_big_height),"style='width:40px;'");?> px</td>
</tr>
<?//big width?>
<tr <?if(!in_array(@$type,array('file'))):?>style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("image_big_width")?>:</td>
	<td><?=form_input("image_big_width",set_value('image_big_width',@$image_big_width),"style='width:40px;'");?> px</td>
</tr>
<?//big crop?>
<tr <?if(!in_array(@$type,array('file'))):?>style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("image_big_crop")?>:</td>
	<td><?=form_dropdown("image_big_crop",array(0=>language('no'),1=>language('yes')),set_value('image_big_crop',@$image_big_crop),"style='width:50px;'");?></td>
</tr>


<?//content?>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr <?if(!in_array(@$type,array('content'))):?>style="display:none;"<?endif?>>
	<td width="150"><?=$BC->_getFieldTitle("content")?> (<?=$lang_code?>): <span class="red">*</span></td>
	<td><?=form_textarea("content[{$lang_code}]",set_value("content[{$lang_code}]",@$content[$lang_code]),"class='richtext'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>

</table>

<p><?=form_button("button",language('save'),"class='submit'");?></p>

</form>


<?load_theme_view('inc/js-multilang-help-tools')?>