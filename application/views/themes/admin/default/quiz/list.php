<!--Load JS-->
<?=load_inline_js('inc/js-select_all'); ?>

<script>
    window.quizCopyQuestionsUrl = '<?=site_url($BC->_getBaseURI().'/copyQuestions')?>';
</script>
<?=include_js($BC->_getFolder('js').'custom/quiz/admin/paste-questions.js')?>
<!--Load JS-->

<div class="fl" style="width:50%;">
   <?=load_theme_view('inc/tpl-filters');?>
</div>

<!--Load Search Form-->
<?php 
$fields_names = array('name','description');
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
            'field'=>'name'
        ),
        array(
            'field'=>'questions_count'
        ),
        array(
            'field'=>'correct_count'
        ),
        array(
            'field'=>'active'
        ),
        array(
            'field'=>'added_questions',
            'title'=>language('added_questions')
        )
    );

    if(@$BC->settings_model['quiz_field_type_id'])
    {
        $col = array(
            'field' => 'type_id',
            'width' => 100
        );
        $cols[] = $col;
    }
    
    $rows = $query->result_array();
    
    //prepare rows for output
    foreach ($rows as &$row)
    {
        $row['name__output'] = anchor($BC->_getBaseURI().'/questions_list/'.$row['id'],$row['name']);
        $row['active__output'] = (($row['active'])?language('yes'):language('no'));
        $row['added_questions__output'] = $BC->quiz_model->getTotalQuizQuestions($row['id']);
    }
    
    show_records_table($cols,$rows);
    ?>
    
    </form>
    
    <div class="pagination"><?=$paginate?></div>

<?endif;?>