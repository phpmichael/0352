
    <h2><?=$BC->_getPageTitle()?></h2>

    <div class="boxIndent">
        <?if($orders):?>
            <table class="box-table-a">
			<thead>
				<tr>
					<th width="70%"><?=language("order")?></th>
					<th width="15%"><?=language("date")?></th>
					<th width="15%"><?=language("status")?></th>
				</tr>
			</thead>
			
			<tbody>
			<?foreach ($orders as $key=>$row):?>
			<tr>
				<td><?=$BC->orders_model->show($row->id)?></td>
				<td style="vertical-align:middle;padding:0 3px;"><?=$row->date?></td>
				<td style="vertical-align:middle;padding:0 3px;"><?=$BC->orders_model->getStatusText($row->status)?></td>
			</tr>
			<?endforeach;?>
			</tbody>
			
			</table>
		<?else:?>
		    <h2><?=language('your_orders_list_is_empty')?></h2>
		<?endif?>
    </div>
 