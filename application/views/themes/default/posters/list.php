<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<p class="hide" id="search_creteria">
	<a href="javascript:void(0)" class="big"><?=language('change_search_criterias')?></a>
</p>

<div id="search_from">
	<?load_theme_view('inc/form-search-posters')?>
</div>

<table width="100%">

<?if( $posts_list ): $i=0?>

<?foreach ($posts_list as $row): $i++?>
<tr class="row<?if($i%2):?>A<?else:?>B<?endif?>">
	<td>
		<a href="<?=site_url($BC->_getBaseURL().'posters/view/'.$row->id)?>" class="img_box">
			<?if($row->image) echo img('images/data/s/posters/'.$row->image)?>
		</a>
	</td>
	<td>
		<table width="100%">
		<tr>
			<td colspan="2"><?=anchor_base('posters/view/'.$row->id,$row->title)?></td>
		</tr>
		<tr>
			<td width="65%">
				<?=nl2br(word_limiter($row->text,10))?>
			</td>
			<td width="35%">
				<?=language('added_date')?>: <?=substr($row->pub_date,0,16)?>
			</td>
		</tr>
		</table>
	</td>
	
</tr>
<?endforeach;?>

<?else:?>
<h2><?=language('search_did_not_give_any_results')?></h2>
<?endif?>

</table>

<div class="pagination"><?=$paginate?></div>

<script>
var hidden_search_form = <?if(!isset($empty_filter)):?>true<?else:?>false<?endif?>;
</script>
<?=include_js($BC->_getFolder('js').'custom/search_form.js')?>