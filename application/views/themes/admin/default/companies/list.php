<!--Load JS-->
<?=load_inline_js('inc/js-select_all'); ?>
<!--Load JS-->

<!--Load Search Form-->
<?php 
$fields_names = array('name','email','phone','phone2','fax','website','city','region','address','email','work_time','short_description','services');
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
            'field'=>'email'
        ),
        array(
            'field'=>'phone'
        ),
        array(
            'field'=>'pub_date'
        )
    );
    
    $rows = $query->result_array();
    
    //prepare rows for output
    foreach ($rows as &$row)
    {
        $row['pub_date__output'] = substr($row['pub_date'],0,16);
    }
    
    show_records_table($cols,$rows);
    ?>
    
    </form>
    
    <div class="pagination"><?=$paginate?></div>

<?endif;?>