<!--Load JS-->
<?=load_inline_js('inc/js-select_all'); ?>
<!--Load JS-->

<!--Load Search Form-->
<?php 
$fields_names = array('page_title','body');
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
            'field'=>'page_title'
        ),
        array(
            'field'=>'link',
            'just_text'=>TRUE
        ),
        array(
            'field'=>'is_content'
        )
    );
    
    $rows = $query->result_array();
    
    //prepare rows for output
    foreach ($rows as &$row)
    {
        //show page link
        $row['link__output'] = (($row['is_content']=='yes' && $row['id']!=1)?("page/".$row['slug'].$BC->config->item('url_suffix')):(($row['link'])?$row['link'].$BC->config->item('url_suffix'):""));
        
        //don't display checkbox for system pages that could not be removed
        if($row['is_content']!='yes' || $row['id']==1 || $row['link']) $row['__no_checkbox'] = TRUE;
    }
    
    show_records_table($cols,$rows);
    ?>
    
    </form>
    
    <div class="pagination"><?=$paginate?></div>

<?endif;?>