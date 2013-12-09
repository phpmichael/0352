<!--Load JS-->
<?php $this->load->view('inc/js-select_all'); ?>
<!--Load JS-->

<?=br(2)?>

<? 
$form_id = $this->uri->segment($BC->_getSegmentsOffset()+3);
$container_id = $this->uri->segment($BC->_getSegmentsOffset()+4);
?>

<p>
<?=anchor($BC->_getBaseURI(),'Forms')?> 
<?if(userAccess($BC->_getController(),'edit')):?>
| <?=anchor($BC->_getBaseURI().'/edit/id/asc/0/'.$form_id,'Edit Form')?>
<?endif?>
<?if(userAccess($BC->_getController(),'add')):?>
| <?=anchor($BC->_getBaseURI().'/containers_add/'.$form_id.'/'.$container_id,'Add Container')?>
<?endif?>
<?if(userAccess($BC->_getController(),'add') && $container_id):?>
| <?=anchor($BC->_getBaseURI().'/inputs_add/'.$form_id.'/'.$container_id,'Add Input')?>
<?endif?>
</p>

<br />

<?if($query->num_rows()>0):?>

    <?//link for delete selected records?>
    <p><?//=anchor__Delete_Selected()?></p>
    
    <?//lopen form for delete records?>
    <?=aform_open__Delete_Selected()?>
    
    <?//set ouput format
    $cols = array(
        array(
            'field' => 'html_id',
            'width' => 300,
            'just_text'=>TRUE
        ),
        array(
            'field'=>'label',
            'just_text'=>TRUE
        ),
        array(
            'field'=>'containers',
            'title'=>' ',
            'width'=>100
        ),
        array(
            'field'=>'inputs',
            'title'=>' ',
            'width'=>100
        ),
        array(
            'field'=>'container_edit',
            'title'=>' ',
            'width'=>100
        )
    );
    
    $rows = $query->result_array();
    
    //prepare rows for output
    foreach ($rows as &$row)
    {
        $row['containers__output'] = anchor($BC->_getBaseURI().'/containers_list/'.$row['form_id'].'/'.$row['id'],'Containers');
        $row['inputs__output'] = anchor($BC->_getBaseURI().'/inputs_list/'.$row['form_id'].'/'.$row['id'],'Inputs');
        $row['container_edit__output'] = anchor_admin('containers_edit',$row['id']);
    }
    
    show_records_table($cols,$rows,FALSE,FALSE);
    ?>
    
    </form>
    
    <div class="pagination"><?=$paginate?></div>

<?endif;?>