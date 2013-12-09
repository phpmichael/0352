<div id="page">
    <h2 class="title"><span><span><?=$BC->_getPageTitle()?></span></span></h2>

    <div class="boxIndent">
        <div class="wrapper">
            <div class="content">
                <?if($orders):?>
                    <table width="100%">
        			<thead>
        				<tr class="sectiontableheader">
        					<th width="70%"><?=language("order")?></th>
        					<th width="15%"><?=language("date")?></th>
        					<th width="15%"><?=language("status")?></th>
        				</tr>
        			</thead>
        			
        			<tbody>
        			<?foreach ($orders as $key=>$row):?>
        			<tr class="sectiontableentry1">
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
        </div>
    </div>
</div>