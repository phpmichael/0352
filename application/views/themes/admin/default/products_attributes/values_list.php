<!--Load JS-->
<?=load_inline_js('inc/js-select_all'); ?>
<!--Load JS-->

<?=br(2)?>

<? 
$attr_id = $this->uri->segment($BC->_getSegmentsOffset()+3);
?>

<p>
<?=anchor($BC->_getBaseURI(),language('attributes_list'))?> 
<?if(userAccess($BC->_getController(),'edit')):?>
| <?=anchor($BC->_getBaseURI().'/edit/id/asc/0/'.$attr_id,language('edit_attribute'))?>
<?endif?>
<?if(userAccess($BC->_getController(),'add')):?>
| <?=anchor($BC->_getBaseURI().'/values_add/'.$attr_id,language('add_value'))?>
<?endif?>
</p>

<br />

<?if(!empty($values)):?>

    <?//link for delete selected records?>
    <p><?=anchor__Delete_Selected()?></p>
    
    <?//lopen form for delete records?>
    <?=form_open($BC->_getBaseURI()."/delete_selected_values/".$attr_id,array('name'=>'form'))?>
    
    <?//set ouput format
    $cols = array(
        array(
            'field' => 'id',
            'width' => 50
        ),
        array(
            'field'=>'value'
        ),
        array(
            'field'=>'value_edit',
            'title'=>' ',
            'width'=>50
        )
    );
    
    $rows = $values;
    
    //prepare rows for output
    foreach ($rows as &$row)
    {
        $row['value_edit__output'] = anchor_admin('values_edit',$row['id']);
    }
    
    show_records_table($cols,$rows,FALSE,FALSE);
    ?>
    
    </form>

<?endif;?>