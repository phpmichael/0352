<?if(!empty($attributes_list)):?>
    <table>
		<tr>
			<td colspan="2"><b><?=language('attributes')?></b></td>
		</tr>
		<?foreach ($attributes_list as $attr_id=>$attr):?>
		<tr>
			<td><?=$attr['name']?></td>
			<td>
				<?=form_dropdown('products_attributes['.$attr_id.']',$attr['values'])?>
			</td>
		</tr>
		<?endforeach?>
	</table>
<?endif?>