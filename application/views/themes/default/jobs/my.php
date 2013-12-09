<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<p><?=anchor_base('jobs/add',language('add_vacancy'))?></p>

<table width="100%">
<?if(!empty($my_jobs)): $i=0?>

<?foreach ($my_jobs as $row): $i++?>
<tr class="row<?if($i%2):?>A<?else:?>B<?endif?>">
	<td width="100">
		<a href="<?=site_url($BC->_getBaseURL().'jobs/view/'.$row->id)?>" class="img_box">
			<?if($row->image) echo img('images/data/s/jobs/'.$row->image."?no_cache=".time())?>
		</a>
	</td>
	<td><?=$row->title?></td>
	<td width="80">
		<a href="<?=site_url($BC->_getBaseURL()."jobs/edit/$row->id")?>"><?=language('edit')?></a>
		<a href="<?=site_url($BC->_getBaseURL()."jobs/delete/$row->id")?>"><?=language('delete')?></a>
	</td>
</tr>
<?endforeach;?>

<?endif?>

</table>