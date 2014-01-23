<table class="dash-widgets">
<tr>
<?foreach ($widgets as $key=>$widget):?>

	<td style="width:25%; vertical-align:top;" class="dash-widget">

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
		
	</td>
	
<?if(!($key%4)):?></tr><tr><?endif?>

<?endforeach?>
</table>