<?
$quizTypes = array(
    1 => 'Тести УЦОЯО 2010-2019',
    2 => 'Тести за програмою ЗНО 2020 <small>(більше 4000 тестів)</small>',
    3 => 'Тренажер ЗНО 2020',
    4 => 'Блок 4',
    5 => 'Блок 5'
)?>

<h1><?=$quizTypes[$type_id]?></h1>

<?if(!empty($quiz_records)):?>
	<?foreach ($quiz_records as $record):?>
		<h2>
			<a href='<?=site_url($BC->_getBaseURL().'quiz/start/'.$record['id']);?>'><?=$record['name']?></a>
		</h2>
		<?if($record['description']):?>
			<strong><?=language('description')?>:</strong>
			<div>
				<?=$record['description']?>
			</div>
		<?endif?>
	<?endforeach;?>
<?endif;?>