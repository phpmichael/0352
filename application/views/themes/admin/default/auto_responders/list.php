<!--Load JS-->
<?=load_inline_js('inc/js-select_all'); ?>
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
            'field'=>'subject'
        ),
        array(
            'field'=>'enabled',
            'width'=>100
        )
    );
    
    $rows = $query->result_array();
    
    //prepare rows for output
    foreach ($rows as &$row)
    {
        $row['enabled__output'] = (($row['enabled'])?language('yes'):language('no'));
    }
    
    show_records_table($cols,$rows,TRUE);
    ?>
    
    </form>
    
    <div class="pagination"><?=$paginate?></div>

<?endif;?>