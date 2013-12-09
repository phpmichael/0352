<!--Load JS-->
<?php $this->load->view('inc/js-select_all'); ?>
<!--Load JS-->

<?=br(2)?>

<? $quiz_id = $this->uri->segment($BC->_getSegmentsOffset()+3) ?>

<p>
	<?=anchor($BC->_getBaseURI(),language('quiz_list'))?> 
	<?if(userAccess($BC->_getController(),'edit')):?>
		| <?=anchor($BC->_getBaseURI().'/edit/id/asc/0/'.$quiz_id,language('edit_quiz_info'))?>
	<?endif?>
</p>

<?if(userAccess($BC->_getController(),'add')):?>
	<p><?=anchor($BC->_getBaseURI().'/questions_add/'.$quiz_id,language('add_question'))?></p>
<?endif?>

<br />

<?if(!empty($questions)):?>

    <?//link for delete selected records?>
    <p><?=anchor__Delete_Selected()?></p>
    
    <?//lopen form for delete records?>
    <?=form_open($BC->_getBaseURI()."/delete_selected_questions/".$quiz_id,array('name'=>'form'))?>
    
    <?//set ouput format
    $cols = array(
        array(
            'field' => 'id',
            'width' => 50,
            'title' => 'ID'
        ),
        array(
            'field'=>'question',
            'just_text'=>TRUE
        ),
        array(
            'field'=>'question_edit',
            'title'=>' ',
            'width'=>50
        )
    );
    
    $rows = $questions;
    
    //prepare rows for output
    foreach ($rows as &$row)
    {
        $row['question__output'] = anchor($BC->_getBaseURI().'/answers_list/'.$quiz_id.'/'.$row['id'],htmlspecialchars($row['question']));
        $row['question_edit__output'] = anchor_admin('questions_edit',$row['id']);
    }
    
    show_records_table($cols,$rows,FALSE,FALSE);
    ?>
    
    </form>

<?endif;?>