<h1><?=$BC->_getPageTitle()?></h1>

<form action="<?=site_url($BC->_getBaseURI().'/rating')?>" method="post">
<p><?=form_dropdown('quiz_id',$quiz_list,$quiz_id)?> <?=form_submit("submit",language('submit'));?></p>
</form>

<?if(!empty($records)):?>

<table class="table table-bordered">
<tr>
	<th><?=language('name')?></th>
	<th><?=language('result')?></th>
	<th><?=language('time')?></th>
	<th><?=language('date')?></th>
</tr>

<?foreach ($records as $key=>$record):?>

	<tr>
		<td>
			<?=$record['name']?>
		</td>
		<td>
			<?=$record['scores']?>
		</td>
		<td>
			<?=date("i:s",$record['time'])?>
		</td>
		<td>
			<?=date('d/m/Y H:i',$record['finished'])?>
		</td>
	</tr>

<?endforeach;?>

</table>

<?endif;?>