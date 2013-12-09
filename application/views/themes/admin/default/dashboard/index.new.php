<div class="dash-widgets">

<?foreach ($widgets as $key=>$widget):?>

	<div style="vertical-align:top;width:200px;display:table-cell;float:left;" class="dash-widget">

		<table class="list">
			<tr>
				<th>
				    <b><?=$widget['title']?></b>
				</th>
			</tr>
			<tr>
				<td>
					<?=$widget['content']?>
				</td>
			</tr>
		</table>
		
	</div>

<?endforeach?>
</div>