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
	<td><?=$BC->_getFieldTitle("generic_answers")?>:</td>
	<td><?=form_input("generic_answers",set_value('generic_answers',@$generic_answers),"class='largeinput'");?></td>
</tr>

<?if(@$id):?>
<?$inputs_with_answerset = $BC->formbuilder_model->getInputsWithAnswerset($id)?>
<?if(!empty($inputs_with_answerset)):?>
<tr>
	<td><?=count($inputs_with_answerset)?></td>
	<td>
		<ul>
		<?foreach ($inputs_with_answerset as $input):?>
			<li><a href="javascript:void(0)" class="attached-to-input" input_id="<?=$input['id']?>"><?=$input['label']?></a></li> 
		<?endforeach?>
		</ul>
	</td>
</tr>
<?endif?>
<?endif?>

</table>

<p><?=form_button("button",language('save'),"class='submit'");?></p>

</form>


<?load_theme_view('inc/js-multilang-help-tools')?>