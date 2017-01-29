<h1><?=$BC->_getPageTitle()?></h1>

<?if(!empty($quiz_records)):?>
	<?foreach ($quiz_records as $record):?>
		<h2>
			<a href='<?=site_url($BC->_getBaseURL().'quiz/start/'.$record['id']);?>'><?=$record['name']?></a>
		</h2>
		<p>
			<?=language('questions_count')?>: <?=$record['questions_count']?> <br />
			<?=language('require_correct_answers')?>: <?=$record['correct_count']?>
		</p>
		<?if($record['description']):?>
			<strong><?=language('description')?>:</strong>
			<div>
				<?=$record['description']?>
			</div>
		<?endif?>
	<?endforeach;?>
<?endif;?>