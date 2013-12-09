<?if( isset($item['options']) && !empty($item['options']) ):?>
	<table>
		<tr>
			<td colspan="2"><b><?=language('attributes')?></b></td>
		</tr>
		<?foreach ($item['options'] as $option_key => $option_value):?>
		<tr>
			<td width="50%">
				<?=$BC->products_attributes_model->getAttributeNameById($option_key)?>:
			</td>
			<td width="50%">
				<?=$BC->products_attributes_model->getValueTextById($option_value)?>
			</td>
		</tr>
		<?endforeach?>
	</table>
<?endif?>