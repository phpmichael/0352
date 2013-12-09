<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<p class="hide" id="search_creteria">
	<a href="javascript:void(0)" class="big"><?=language('change_search_criterias')?></a>
</p>

<div id="search_from">
	<?load_theme_view('inc/form-search-jobs')?>
</div>

<table width="100%">

<?if( $posts_list ): $i=0?>

<?foreach ($posts_list as $row): $i++?>
<tr class="row<?if($i%2):?>A<?else:?>B<?endif?>">
	<td>
		<a href="<?=site_url($BC->_getBaseURL().'jobs/view/'.$row->id)?>" class="img_box">
			<?if($row->image) echo img('images/data/s/jobs/'.$row->image)?>
		</a>
	</td>
	<td>
		<table width="100%">
		<tr>
			<td colspan="2"><?=anchor_base('jobs/view/'.$row->id,$row->title)?></td>
		</tr>
		<tr>
			<td width="64%">
				<?=language('job_title')?>: <?=$row->position?> <br />
				<?=language('experience')?>: <?=$experienceArr[$row->experience]?> <br />
				<?if($row->salary):?><?=language('salary')?>: <?=$row->salary?> <?=language('uah')?><?endif?>
			</td>
			<td width="36%">
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

<script type="text/javascript">
var hidden_search_form = <?if(!isset($empty_filter)):?>true<?else:?>false<?endif?>;
</script>
<?=include_js($BC->_getFolder('js').'custom/search_form.js')?>