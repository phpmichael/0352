<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<p class="hide" id="search_creteria">
	<a href="javascript:void(0)" class="big"><?=language('change_search_criterias')?></a>
</p>

<div id="search_from">
	<?load_theme_view('inc/form-search-products')?>
</div>

<table width="100%">

<?if( $posts_list ): $i=0?>

<?foreach ($posts_list as $row): $i++?>

<tr class="row<?if($i%2):?>A<?else:?>B<?endif?>">
	<td width="100">
		<a href="<?=site_url($BC->_getBaseURI().'/name/'.$row->slug.url_category_addition())?>" class="img_box">
			<?if(@$row->image) echo img('images/data/s/products/'.$row->image)?>
		</a>
	</td>
	<td>
		<table width="100%">
		<tr>
			<td><?=language('thing_name')?>: <?=anchor($BC->_getBaseURI().'/name/'.$row->slug.url_category_addition(),$row->name)?></td>
			<td>
			    <div class="fr"><?load_theme_view('inc/tpl-add-to-cart',$row)?></div>
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

<?=load_inline_js('inc/js-add-to-cart'); ?>
<?=load_inline_js('inc/js-tooltip'); ?>