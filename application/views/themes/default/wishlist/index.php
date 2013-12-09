<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<?if( $wishlist ):?>

<table width="100%">
<tr class="rowH">
	<th><?=language('thing_name')?></th>
	<th><?=language('price')?></th>
	<th><?=language('delete')?></th>
</tr>
<?foreach ($wishlist as $key=>$row):?>
<tr class="row<?if($key%2):?>A<?else:?>B<?endif?>">
	<td><?=anchor_base('products/view/'.$row['product_id'],$row['product']['name'])?></td>
	<td><?=exchange($row['product']['price'])?></td>
	<td><?=anchor($BC->_getBaseURI().'/remove/'.$row['id'],language('delete'))?></td>
</tr>
<?endforeach;?>
</table>

<?else:?>
<h2><?=language('your_wishlist_is_empty')?></h2>
<?endif?>