<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<p><?=nl2br($text)?></p>

<hr />

<table class="fields_list">

<?if(isset($post_categories)):?>
<tr id="current_category">
	<td class="vt"><?=language('category')?>:</td>
	<td>
		<?foreach ($post_categories as $key=>$category):?>
			<?=$category?> >
		<?endforeach?>
	</td>
</tr>
<?endif?>

<tr>
	<td><?=language('views_count')?>:</td>
	<td><?=$views?></td>
</tr>
</table>

<?if($image):?>
<p><?=img('images/data/b/posters/'.$image)?></p>
<?endif?>

<hr />

<?load_theme_view('inc/post-owner-info')?>

<?=load_inline_js('inc/js-paint-fields-vals')?>