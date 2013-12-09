<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<?if(!empty($quiz_records)):?>

<table>
<tr class="rowH">
	<th><?=language('quiz')?></th>
	<th><?=language('result')?></th>
	<th><?=language('date')?></th>
</tr>

<?foreach ($quiz_records as $key=>$record):?>

	<tr <?if($key%2):?>class="rowB"<?else:?>class="rowA"<?endif?>>
        <?if(isset($record['finished'])):?>
	   
    		<td>
    			<a href='<?=site_url($BC->_getBaseURL().'quiz/result/'.$record['id']);?>'><?=$record['quiz']['name']?></a> 
    		</td>
    		<td <?if( $record['scores'] >= $record['quiz']['correct_count'] ):?>class="green"<?else:?>class="red"<?endif?>>
    			<?=$record['scores']?>/<?=$record['quiz']['questions_count']?>
    		</td>
    		<td>
    			<?=date('d/m/Y H:i',$record['finished'])?>
    		</td>
		
		<?else:?>
		
    		<td>
    			<a href='<?=site_url($BC->_getBaseURL().'quiz/go/'.$record['quiz']['id']);?>'><?=$record['quiz']['name']?></a> 
    		</td>
    		<td>
    			<?=$record['answered']?>/<?=$record['quiz']['questions_count']?>
    		</td>
    		<td>
    			<span class="red"><?=language('not_finished')?></span> 
    			<a href='<?=site_url($BC->_getBaseURL().'quiz/go/'.$record['quiz']['id']);?>'><?=language('continue')?> &gt;&gt;</a> 
    		</td>
		
		<?endif?>
	</tr>

<?endforeach;?>

</table>

<?endif;?>