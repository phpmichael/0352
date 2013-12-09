<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<?if(!empty($quiz_records)):?>
		
<?foreach ($quiz_records as $record):?>
	<p>
		<a href='<?=site_url($BC->_getBaseURL().'quiz/start/'.$record['id']);?>'><?=$record['name']?></a> 
	</p>
	<p>
		<?=language('questions_count')?>: <?=$record['questions_count']?> <br />
		<?=language('require_correct_answers')?>: <?=$record['correct_count']?>
	</p>
	<h4><?=language('description')?>:</h4>
	<div>
		<?=$record['description']?>
	</div>
<?endforeach;?>

<?endif;?>