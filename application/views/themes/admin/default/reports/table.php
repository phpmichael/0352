 <style>
	.report-table{
		
	}	
	.report-table th{
		font-weight:bold;
	}
	.report-table th, .report-table td{
		padding:5px;
		border:1px solid #ccc;
	}
</style>

<table class="report-table">
	<thead>
		<tr>
			<th>Items</th>
			<?foreach ($groups as $group):?>
			<th><?=$group?></th>
			<?endforeach?>
		</tr>
	</thead>
	<tbody>
		<?foreach ($items as $item):?>
		<tr>
			<td><?=$item['name']?></td>
			<?foreach ($groups as $group):?>
			<td><?=intval(@$item['amounts'][$group])?></td>
			<?endforeach?>
		</tr>
		<?endforeach?>
	</tbody>
</table>