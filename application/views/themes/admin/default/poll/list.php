<!--Load JS-->
<?=load_inline_js('inc/js-select_all'); ?>
<!--Load JS-->

<div class="fl" style="width:50%;">
   <?=load_theme_view('inc/tpl-filters');?>
</div>

<!--Load Search Form-->
<?php 
$fields_names = array('title');
load_theme_view('inc/form-search',array('fields_names'=>$fields_names));
?>
<!--Load Search Form-->

<div class="clear"></div>

<br />

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
            'field'=>'title'
        ),
        array(
            'field'=>'active'
        )
    );
    
    $rows = $query->result_array();
    
    //prepare rows for output
    foreach ($rows as &$row)
    {
        $row['title__output'] = anchor($BC->_getBaseURI().'/answers_list/'.$row['id'],$row['title']);
        $row['active__output'] = (($row['active'])?language('yes'):language('no'));
    }
    
    show_records_table($cols,$rows);
    ?>
    
    </form>
    
    <div class="pagination"><?=$paginate?></div>

<?endif;?>