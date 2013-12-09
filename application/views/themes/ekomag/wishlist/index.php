
    <h2><?=$BC->_getPageTitle()?></h2>

    <div class="boxIndent">
		<?if( $wishlist ):?>
			<table class="box-table-a">
			<thead>
				<tr>
					<th><?=language('thing_name')?></th>
					<th style="width:100px;text-align:right;"><?=language('price')?></th>
					<th style="width:50px;text-align:right;"></th>
				</tr>
			</thead>
			
			<tbody>
				<?foreach ($wishlist as $key=>$row):?>
				<tr>
					<td><?=anchor_base('products/name/'.$row['product']['slug'],utf8_wordwrap($row['product']['name'],50,' '))?></td>
					<td style="text-align:right"><?=exchange($row['product']['price'])?></td>
					<td style="text-align:right;">
						<a href="<?=site_url($BC->_getBaseURI().'/remove/'.$row['id'])?>" title="<?=language('delete')?>" class="delete-item btn-remove"><a href="<?=site_url($BC->_getBaseURI().'/remove/'.$row['id'])?>" title="<?=language('delete')?>"><?=img(base_url().$BC->_getTheme().'images/remove_from_cart.png')?></a>
					</td>
				</tr>
				<?endforeach;?>
			</tbody>
			</table>
		<?else:?>
		     <h2><?=language('your_wishlist_is_empty')?></h2>
		<?endif?>
    </div>
