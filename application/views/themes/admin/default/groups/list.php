<!--Load JS-->
<?=load_inline_js('inc/js-select_all'); ?>
<!--Load JS-->

<div class="fl" style="width:50%;">
   <?=load_theme_view('inc/tpl-filters');?>
</div>
<div class="clear"></div>

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
            'field'=>'admin_access',
            'width'=>150
        ),
        array(
            'field'=>'edit_rights',
            'title'=>' ',
            'width'=>80
        )
    );
    
    $rows = $query->result_array();
    
    //prepare rows for output
    foreach ($rows as &$row)
    {
        $row['admin_access__output'] = (($row['admin_access'])?language('yes'):language('no'));
        $row['edit_rights__output'] = anchor_admin('edit_rights',$row['id']);
    }
    
    show_records_table($cols,$rows);
    ?>
    
    </form>
    
    <div class="pagination"><?=$paginate?></div>

<?endif;?>