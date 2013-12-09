<!--Load JS-->
<?php $this->load->view('inc/js-select_all'); ?>
<!--Load JS-->

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
        array(
            'field'=>'code'
        ),
        array(
            'field'=>'title'
        ),
        array(
            'field'=>'exchange_rate'
        ),
        array(
            'field'=>'symbol'
        ),
        array(
            'field'=>'symbol_location'
        ),
        array(
            'field'=>'default'
        ),
        array(
            'field'=>'enabled'
        )
    );
    
    $rows = $query->result_array();
    
    //prepare rows for output
    foreach ($rows as &$row)
    {
        $row['symbol_location__output'] = language($row['symbol_location']);
        $row['default__output'] = (($row['default'])?language('yes'):language('no'));
        $row['enabled__output'] = (($row['enabled'])?language('yes'):language('no'));
    }
    
    show_records_table($cols,$rows);
    ?>
    
    </form>
    
    <div class="pagination"><?=$paginate?></div>

<?endif;?>