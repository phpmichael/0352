<table class="fields_list">
<tr>
	<td class="vt"><?=language('category')?>:</td>
	<td>
		<?foreach ($post_categories as $key=>$category):?>
			<?if(!isset($main_category)): $main_category=true;?>
				<b><a href="<?=site_url($BC->_getBaseURI().'/'.$method.'/category/'.$key)?>"><?=$category?></a></b><br />
			<?else:?>
				&nbsp;<a href="<?=site_url($BC->_getBaseURI().'/'.$method.'/category/'.$key)?>"><?=$category?></a><br />
			<?endif?>
		<?endforeach?>
	</td>
</tr>
</table>