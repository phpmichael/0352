<?$answers = $BC->formbuilder_model->getAnswersetsValues($items[0]['answerset_id']);?>

<table 
	class="answerset-table 
	<?$BC->formbuilder_model->incListRowNumber();?>
	<?if($BC->formbuilder_model->getListRowNumber()%2):?>
		list-row-odd
	<?else:?>
		list-row-even
	<?endif?>
">
	<thead>
		<tr>
			<th style="width:<?=2*intval(100/(count($answers)+2))?>%"></th>
			<?$i=0; foreach ($answers as $answer): $i++;?>
			<th style="width:<?=intval(100/(count($answers)+2))?>%" class="<?if($i%2):?>col-odd<?else:?>col-even<?endif?>"><?=$answer['label']?></th>
			<?endforeach?>
		</tr>
	</thead>
	<tbody>
		<?foreach ($items as $item):?>
		<tr>
			<td><?=$item['label']?></td>
			<?$i=0; foreach ($answers as $answer): $i++;
				$answer_value = $BC->formbuilder_model->getAnswerValue($answer);
	        	$checked = ($answer_value==$item['value']);
			?>
			<td class="<?if($i%2):?>col-odd<?else:?>col-even<?endif?>">
				<?if($item['type']=='radio'):?>
					<?=form_radio($BC->formbuilder_model->getInputName($item),$answer_value,$checked)?>
				<?elseif($item['type']=='checkbox'):?>
					<?=form_checkbox($BC->formbuilder_model->getInputName($item)."[]",$answer_value,$checked)?>
				<?endif?>
			</td>
			<?endforeach?>
		</tr>
		<?endforeach?>
	</tbody>
</table>