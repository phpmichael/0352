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
            'field'=>'name'
        )
    );
    
    $rows = $query->result_array();
    
    //prepare rows for output
    foreach ($rows as &$row)
    {
        $row['name__output'] = ($row['link']) ? "<a href='{$row['link']}' target='_blank'>".$row['name']."</a>" : $row['name'];
    }
    
    show_records_table($cols,$rows);
    ?>
    
    </form>
    
    <div class="pagination"><?=$paginate?></div>

<?endif;?>