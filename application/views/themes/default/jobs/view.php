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
	<td><?=language('job_title')?>:</td>
	<td><?=$position?></td>
</tr>
<tr>
	<td><?=language('experience')?>:</td>
	<td><?=$experienceArr[$experience]?></td>
</tr>
<tr>
	<td><?=language('salary')?>:</td>
	<td><?=$salary?> <?=language('uah')?></td>
</tr>
<tr>
	<td><?=language('views_count')?>:</td>
	<td><?=$views?></td>
</tr>
</table>

<?if($image):?>
<p><?=img('images/data/b/jobs/'.$image)?></p>
<?endif?>

<hr />

<?load_theme_view('inc/post-owner-info')?>

<?=load_inline_js('inc/js-paint-fields-vals')?>