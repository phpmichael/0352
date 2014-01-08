<?$loc_length = @count($current_location_arr); $i=0;?>
<ul class="breadcrumb">
<?foreach ($current_location_arr as $loc_url=>$loc_title): $i++;?>
<?$loc_url = str_replace('products','books',$loc_url);?>
	<?if($i==$loc_length):?>
	<li><a href="javascript:;" class="active"><?=$loc_title?></a></li>
	<?else:?>
	<li><a href="<?=site_url($loc_url)?>"><?=$loc_title?></a> <span class="divider">/</span></li>
	<?endif?>
<?endforeach;?>
</ul>