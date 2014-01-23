<div class="red"><?=validation_errors()?></div>

<?
//get list: panel=>sections=>rights
$available_rights = $BC->groups_model->getAvailableRights();
//get group's rights
$group_rights = $BC->groups_model->getGroupRights($group_id);

$are_rights = FALSE;

?>

<?=form_open()?>
<?=form_hidden('group_id',$group_id)?>

<?foreach (array('front','admin') as $panel):?>

<?if($panel=='front' || $BC->groups_model->hasAdminAccess($group_id)): //show admin sections just if group has admin access?>

<?if(!empty($available_rights[$panel])):?>

<?$are_rights = TRUE;?>

<h2>Panel: <?=$panel?></h2>

<table class="list">
<tr>
	<th width="200">
	   <?=language('section')?> 
	   (<a href="javascript:void(0)" class="all-rights">All</a> /
	   <a href="javascript:void(0)" class="none-rights">None</a> 
	   <?=language('rights')?>)
	</th>
	<!-- Right Name: view, edit, add, delete etc -->
	<?foreach ($BC->groups_model->getRightsList($panel) as $right):?>
	<th><a href="javascript:void(0)" class="right-type"><?=$right?></a></th>
	<?endforeach?>
</tr>


<?foreach ($available_rights[$panel] as $section=>$available_right):?>
<tr>
    <!-- Section Name: customers, news, articles, pages -->
	<td><a href="javascript:void(0)" class="section-rights" rel="<?=$panel.'['.$section.']'?>"><?=$section?></a></td>
	<?foreach ($BC->groups_model->getRightsList($panel) as $right):?>
	<?if(in_array($right,$available_right)):?>
	<td>
	   <!-- Right - enabled/disabled -->
	   <?=form_checkbox($panel.'['.$section.'][]',$right,$BC->groups_model->allowedRight($section,$right,$group_rights,$panel),"class='section-right' id='section-right-{$section}-{$right}'")?> 
	   <label for="<?="section-right-{$section}-{$right}"?>"><?=$right?></label>
	</td>
	<?else:?>
	<td></td>
	<?endif?>
	<?endforeach?>
</tr>
<?endforeach?>

</table>

<?endif?>

<?endif?>

<?endforeach?>

<?if($are_rights):?>
<p><?=form_submit("submit",language('save'));?></p>
<?endif?>

</form>


<?=load_inline_js('inc/js-multilang-help-tools')?>

<?=include_js($BC->_getFolder('js').'jquery/mylib/jquery.check.js')?>

<?=load_inline_js('inc/js-edit-rights')?>