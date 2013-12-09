<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<?if($orders):?>
    <table width="100%">
    <tr class="rowH">
    	<th><?=language("order")?></th>
    	<th><?=language("date")?></th>
    	<th><?=language("status")?></th>
    </tr>
    <?foreach ($orders as $key=>$row):?>
    <tr <?if($key%2):?>class="rowB"<?else:?>class="rowA"<?endif?>>
    	<td><?=$BC->orders_model->show($row->id)?></td>
    	<td class="vm"><?=$row->date?></td>
    	<td class="vm"><?=$BC->orders_model->getStatusText($row->status)?></td>
    </tr>
    <?endforeach;?>
    </table>
<?else:?>
    <h2><?=language('your_orders_list_is_empty')?></h2>
<?endif?>