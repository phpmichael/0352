<?=$BC->formbuilder_model->outputSkipRule($item)?> 

class="
<?if( !isset($item['children']) ): 
	if( !isset($parent['template']) || //form (list template)
		($parent['template']=='columns' && ($col_num>1 && ($col_num-1)%$parent['columns']==0) ) || //container with columns template
		$parent['template']=='list' //container with list template
	)
	{
		$BC->formbuilder_model->incListRowNumber(); 
	}
	
	if($BC->formbuilder_model->getListRowNumber()%2):?>
		list-row-odd
	<?else:?>
		list-row-even
	<?endif?> 
<?else:?>
	fb-container
<?endif?>

<?if( isset( $parent['template']) && $parent['template']=='columns'):?>
	col-of-<?=$parent['columns']?>-cols
<?endif?>

"