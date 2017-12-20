<!--Load JS-->
<?=load_inline_js('inc/js-select_all'); ?>
<!--Load JS-->

<?=br(2)?>

<? 
$quiz_id = $this->uri->segment($BC->_getSegmentsOffset()+3);
$question_id = $this->uri->segment($BC->_getSegmentsOffset()+4);
?>

<p>
	<?=anchor($BC->_getBaseURI(),language('quiz_list'))?> 
	<?if(userAccess($BC->_getController(),'edit')):?>
		| <?=anchor($BC->_getBaseURI().'/edit/id/asc/0/'.$quiz_id,language('edit_quiz_info'))?>
	<?endif?>
</p>
<p>
	<?=anchor($BC->_getBaseURI().'/questions_list/'.$quiz_id,language('questions_list'))?> 
	<?if(userAccess($BC->_getController(),'edit')):?>
		| <?=anchor($BC->_getBaseURI().'/questions_edit/'.$quiz_id.'/asc/0/'.$question_id,language('edit_question'))?>
	<?endif?>
</p>

<?if(userAccess($BC->_getController(),'add')):?>
	<p><?=anchor($BC->_getBaseURI().'/answers_add/'.$quiz_id.'/'.$question_id,language('add_answer'))?></p>
<?endif?>

<br />

<?if(!empty($answers)):?>

    <?//link for delete selected records?>
    <p><?=anchor__Delete_Selected()?></p>
    
    <?//lopen form for delete records?>
    <?=form_open($BC->_getBaseURI()."/delete_selected_answers/".$quiz_id.'/'.$question_id,array('name'=>'form'))?>
    
    <?//set ouput format
    $cols = array(
        array(
            'field' => 'id',
            'width' => 50,
            'title' => 'ID'
        ),
        array(
            'field'=>'answer',
            'just_text'=>TRUE
        ),
        array(
            'field'=>'correct',
            'just_text'=>TRUE
        ),
        array(
            'field'=>'answer_edit',
            'title'=>' ',
            'width'=>50
        )
    );

    //set connected answer: start
    if(!empty($connected_answers)){
        $col = array(
            'field'=>'connected_answer',
            'just_text'=>TRUE
        );
        $cols[] = $col;
    }
    //set connected answer: end

    if(@$BC->settings_model['quiz_answer_field_image'])
    {
        $col = array(
            'field' => 'image',
            'width' => 100,
            'title'=>language('image')
        );
        $cols[] = $col;
    }
    
    $rows = $answers;
    
    //prepare rows for output
    foreach ($rows as &$row)
    {
        //set connected answer: start
        if(!empty($connected_answers))
        {
            foreach ($connected_answers as $connected_answer)
            {
                if($connected_answer['connect_answer'] == $row['id']){
                    $row['connected_answer'] = $connected_answer['answer'] .' '. anchor_admin('answers_edit',$connected_answer['id']);
                }
            }
        }
        //set connected answer: end

        $row['correct__output'] = (($row['correct'])?language('yes'):language('no'));
        if($row['image']) $row['image__output'] = "<a href='".base_url().'images/data/b/quiz/'.$row['image']."' rel='facebox'>".img(array('src'=>'images/data/b/quiz/'.$row['image']."?no_cache=".time(),'width'=>100))."</a>";
        $row['answer_edit__output'] = anchor_admin('answers_edit',$row['id']);
    }
    
    show_records_table($cols,$rows,FALSE,FALSE);
    ?>
    
    </form>

<?endif;?>

<?=load_inline_js('inc/js-facebox'); ?>
