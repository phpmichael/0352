<!--Load JS-->
<?=load_inline_js('inc/js-select_all'); ?>
<!--Load JS-->

<div class="fl" style="width:50%;">
   <?=load_theme_view('inc/tpl-filters');?>
</div>
<div class="clear"></div>

<?=br(2)?>

<?if($query->num_rows()>0):?>

    <?//link for delete selected records?>
    <p><?=anchor__Delete_Selected()?></p>
    
    <?//lopen form for delete records?>
    <?=aform_open__Delete_Selected()?>
    
    <?//set ouput format
    $cols = array(
        array(
            'field' => 'id',
            'width' => 50
        ),
        /*array(
            'field'=>'customer_id'
        ),*/
        array(
            'field'=>'order',
            'just_text'=>TRUE
        ),
        array(
            'field'=>'total'
        ),
        array(
            'field'=>'date',
            'width' => 70
        ),
        array(
            'field'=>'status'
        )
    );
    
    $rows = $query->result_array();
    
    //prepare rows for output
    foreach ($rows as &$row)
    {
        //$row['customer_id__output'] = (userAccess('customers','edit')? anchor_base("/customers/edit/id/desc/0/".$row['customer_id'], $BC->customers_model->getFullNameById($row['customer_id'])) : $BC->customers_model->getFullNameById($row['customer_id']) );
        $row['order__output'] = $BC->orders_model->show($row['id']);
        $row['total__output'] = exchange($row['total']);
        $row['date__output'] = substr($row['date'],0,16);
        $row['status__output'] = $BC->orders_model->getStatusText($row['status']);
        $row['status__bgColor'] = $BC->orders_model->getStatusBgColor($row['status']);
    }
    
    show_records_table($cols,$rows);
    ?>
    
    </form>
    
    <div class="pagination"><?=$paginate?></div>

<?endif;?>