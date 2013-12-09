<?php load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<p class="hide" id="search_creteria">
	<a href="javascript:void(0)" class="big"><?=language('change_search_criterias')?></a>
</p>

<div id="search_from">
	<?load_theme_view('inc/form-search-companies')?>
</div>

<table width="100%">

<?if( $posts_list ): $i=0?>

<?foreach ($posts_list as $row): $i++?>

<tr class="row<?if($i%2):?>A<?else:?>B<?endif?>">
	<td width="100">
		<a href="<?=site_url($BC->_getBaseURL().'companies/view/'.$row->id.url_category_addition())?>" class="img_box">
			<?if(@$row->image) echo img('images/data/s/companies/'.$row->image)?>
		</a>
	</td>
	<td>
		<table width="100%" border="1">
		<tr>
			<td><?=anchor_base('companies/view/'.$row->id.url_category_addition(),$row->name)?></td>
		</tr>
		<tr>
			<td>
				<?load_theme_view('inc/tpl-company-preview',$row)?>
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