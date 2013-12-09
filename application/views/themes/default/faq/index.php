<?load_theme_view('inc/tpl-cur-location'); ?>

<h2><?=$BC->_getPageTitle()?></h2>

<?if(!empty($faq_records)):?>

<?foreach ($faq_records as $record):?>
	<h3><?=$record['question']?></h3>
	
	<p>
		<?=nl2br($record['answer'])?>
	</p>
<?endforeach;?>

<div class="pagination"><?=$paginate?></div>

<?endif;?>