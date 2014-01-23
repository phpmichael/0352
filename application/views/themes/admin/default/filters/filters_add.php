<? 
$filter_id = $this->uri->segment($BC->_getSegmentsOffset()+3);
?>

<p>
	<?=anchor($BC->_getBaseURI(),language('filters_groups'))?> 
	<?if(userAccess($BC->_getController(),'edit')):?>
		| <?=anchor($BC->_getBaseURI().'/edit/id/asc/0/'.$filter_group_id,language('edit_filter_group'))?>
	<?endif?>
</p>

<p><?=anchor($BC->_getBaseURI().'/filters_list/'.$filter_group_id,language('filters_list'))?></p>

<div class="red"><?=validation_errors()?></div>

<?=form_open()?>

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?>.</td>
</tr>
<!--
<tr>
	<td><?=$BC->_getFieldTitle("filter_group_id")?>:</td>
	<td><?=form_dropdown("filter_group_id",$BC->filters_model->getGroupsList(),set_value('filter_group_id',@$filter_group_id));?></td>
</tr>
-->
<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("title")?> (<?=$lang_code?>): <span class="red">*</span></td>
	<td><?=form_input("title[{$lang_code}]",set_value("title[{$lang_code}]",@$title[$lang_code]),"class='largeinput'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>
<tr>
	<td><?=$BC->_getFieldTitle("code")?>: <span class="red">*</span></td>
	<td><?=form_input("code",set_value("code",@$code),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("query")?>: <span class="red">*</span></td>
	<td><?=form_input("query",set_value("query",@$query),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("active")?>:</td>
	<td><?=form_dropdown("active",array(0=>language('no'),1=>language('yes')),set_value('active',@$active));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("panel")?>:</td>
	<td><?=form_dropdown("panel",array('admin'=>'admin','front'=>'front','both'=>'both'),set_value('panel',@$panel));?></td>
</tr>
</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>

<?=load_inline_js('inc/js-multilang-help-tools')?>