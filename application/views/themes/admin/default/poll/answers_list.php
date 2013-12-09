<!--Load JS-->
<?php $this->load->view('inc/js-select_all'); ?>
<!--Load JS-->

<?=br(2)?>

<? 
$poll_id = $this->uri->segment($BC->_getSegmentsOffset()+3);
?>

<p>
<?=anchor($BC->_getBaseURI(),language('poll_list'))?> 
<?if(userAccess($BC->_getController(),'edit')):?>
| <?=anchor($BC->_getBaseURI().'/edit/id/asc/0/'.$poll_id,language('edit_poll_info'))?>
<?endif?>
<?if(userAccess($BC->_getController(),'add')):?>
| <?=anchor($BC->_getBaseURI().'/answers_add/'.$poll_id,language('add_answer'))?>
<?endif?>
</p>

<br />

<?if(!empty($answers)):?>

    <?//link for delete selected records?>
    <p><?=anchor__Delete_Selected()?></p>
    
    <?//lopen form for delete records?>
    <?=form_open($BC->_getBaseURI()."/delete_selected_answers/".$poll_id,array('name'=>'form'))?>
    
    <?//set ouput format
    $cols = array(
        array(
            'field' => 'id',
            'width' => 50,
            'just_text'=>TRUE
        ),
        array(
            'field'=>'answer',
            'just_text'=>TRUE
        ),
        array(
            'field'=>'answer_edit',
            'title'=>' ',
            'width'=>50
        )
    );
    
    $rows = $answers;
    
    //prepare rows for output
    foreach ($rows as &$row)
    {
        $row['answer_edit__output'] = anchor_admin('answers_edit',$row['id']);
    }
    
    show_records_table($cols,$rows,FALSE,FALSE);
    ?>
    
    </form>

<?endif;?>