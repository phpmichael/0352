<div class="main-block">
    <div class="top-corners"><div><div>&nbsp;</div></div></div>

    <div class="corner">
        <div class="full-width">
            <div class="page-title">
                <h1><?=$BC->_getPageTitle()?></h1>
            </div>
            <?if($orders):?>
    			<table class="data-table">
    			<thead>
    				<tr>
    					<th><?=language("order")?></th>
    					<th><?=language("date")?></th>
    					<th><?=language("status")?></th>
    				</tr>
    			</thead>
    			
    			<tbody>
    			<?foreach ($orders as $key=>$row):?>
    			<tr <?if($key%2):?>class="rowB"<?else:?>class="rowA"<?endif?>>
    				<td><?=$BC->orders_model->show($row->id)?></td>
    				<td class="vm"><?=$row->date?></td>
    				<td class="vm"><?=$BC->orders_model->getStatusText($row->status)?></td>
    			</tr>
    			<?endforeach;?>
    			</tbody>
    			</table>
			
			<?else:?>
			    <h2><?=language('your_orders_list_is_empty')?></h2>
			<?endif?>
				
		</div>
    </div>

    <div class="bot-corners"><div><div>&nbsp;</div></div></div>
</div>