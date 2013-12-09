<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<?if(!empty($links_records)):?>
		
<?foreach ($links_records as $record):?>
<p>
	<?=anchor($BC->_getBaseURI().'/go/'.$record['id'],$record['name'],array('target'=>'_blank'))?>
</p>
<p>
	<?=nl2br($record['description'])?>
</p>
<?endforeach;?>

<div class="pagination"><?php echo $paginate; ?></div>

<?endif;?>