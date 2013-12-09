<div class="main-block">
    <div class="top-corners"><div><div>&nbsp;</div></div></div>

    <div class="corner">
        <div class="full-width">
            <div class="page-title">
                <h1><?=$BC->_getPageTitle()?></h1>
            </div>
			
			<?if( $wishlist ):?>
			
			<table class="data-table">
			<thead>
				<tr>
					<th><?=language('thing_name')?></th>
					<th style="width:50px;text-align:right;"><?=language('price')?></th>
					<th style="width:50px;text-align:right;"><?=language('delete')?></th>
				</tr>
			</thead>
			
			<tbody>
				<?foreach ($wishlist as $key=>$row):?>
				<tr class="row<?if($key%2):?>A<?else:?>B<?endif?>">
					<td><?=anchor_base('products/name/'.$row['product']['slug'],$row['product']['name'])?></td>
					<td style="text-align:right"><?=exchange($row['product']['price'])?></td>
					<td>
						<a href="<?=site_url($BC->_getBaseURI().'/remove/'.$row['id'])?>" title="<?=language('delete')?>" class="delete-item btn-remove"></a>
					</td>
				</tr>
				<?endforeach;?>
			</tbody>
			</table>
			
			<?else:?>
			<h2><?=language('your_wishlist_is_empty')?></h2>
			<?endif?>
			
		</div>
    </div>

    <div class="bot-corners"><div><div>&nbsp;</div></div></div>
</div>