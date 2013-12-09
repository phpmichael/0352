<div id="ajax_response"></div>

<?=form_open()?>

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?>.</td>
</tr>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("label")?> (<?=$lang_code?>): <span class="red">*</span></td>
	<td><?=form_input("label[{$lang_code}]",set_value("label[{$lang_code}]",@$label[$lang_code]),"class='largeinput'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>
<tr>
	<td><?=$BC->_getFieldTitle("html_id")?>:</td>
	<td><?=form_input("html_id",set_value('html_id',@$html_id));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("type")?>: <span class="red">*</span></td>
	<td><?=form_dropdown("type",array('regular'=>'regular'),set_value('type',@$type));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("template")?>: <span class="red">*</span></td>
	<td>
		<?=form_dropdown("template",array('list'=>'list','columns'=>'columns','answerset_table'=>'answerset_table','include'=>'include'),set_value('template',@$template));?>
		<?=form_input("template",set_value('template',@$template), (!stristr(@$template,"/"))?" disabled='disabled' class='hide'":"");?>
	</td>
</tr>
<tr <?if(@$template!='columns'):?>style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("columns")?>: <span class="red">*</span></td>
	<td><?=form_dropdown("columns",array(2=>2,3=>3),set_value('columns',@$columns),"style='width:50px;'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("hide_label")?>: <span class="red">*</span></td>
	<td><?=form_dropdown("hide_label",array('no'=>language('no'),'yes'=>language('yes')),set_value('hide_label',@$hide_label),"style='width:50px;'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("html_class")?>:</td>
	<td><?=form_input("html_class",set_value('html_class',@$html_class));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("skip_rule")?>:</td>
	<td><?=form_input("skip_rule",set_value('skip_rule',@$skip_rule));?></td>
</tr>
</table>

<p><?=form_button("button",language('save'),"class='submit'");?></p>

</form>


<?load_theme_view('inc/js-multilang-help-tools')?>