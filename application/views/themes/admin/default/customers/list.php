<!--Load JS-->
<?php $this->load->view('inc/js-select_all'); ?>
<!--Load JS-->

<!--Load Search Form-->
<?php 
$fields_names = array('name','surname','email','phone','phone2','website','city','address');
load_theme_view('inc/form-search',array('fields_names'=>$fields_names));
?>
<!--Load Search Form-->

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
        array(
            'field'=>'name'
        ),
        array(
            'field'=>'surname'
        ),
        array(
            'field'=>'email'
        ),
        array(
            'field'=>'phone'
        ),
        array(
            'field'=>'phone2'
        ),
        array(
            'field'=>'website'
        ),
        array(
            'field'=>'reg_date'
        ),
    );
    
    $rows = $query->result_array();
    
    //prepare rows for output
    foreach ($rows as &$row)
    {
        $row['website__output'] = ((strlen($row['website'])>40)?substr($row['website'],0,30).'...':$row['website']);
        $row['reg_date__output'] = substr($row['reg_date'],0,16);
    }
    
    show_records_table($cols,$rows);
    ?>
    
    </form>
    
    <div class="pagination"><?=$paginate?></div>

<?endif;?>