<!--Load JS-->
<?=load_inline_js('inc/js-select_all'); ?>
<?=load_inline_js('inc/js-jquery-ui'); ?>

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
    <p>
        <?=anchor__Delete_Selected()?>

        <?if(userAccess($BC->_getController(),'edit')):?>
            | <a id="save" href="javascript:void(0)"><?=language('save_sorting')?></a>
        <?endif?>
    </p>
    
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
            'field'=>'questions_count',
            'width'=>100,
        ),
        array(
            'field'=>'correct_count',
            'width'=>100,
        ),
        array(
            'field'=>'active',
            'width'=>100,
        ),
        array(
            'field'=>'added_questions',
            'title'=>language('added_questions'),
            'width'=>100,
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

    show_records_sortable($cols,$rows,FALSE,FALSE);
    ?>
    
    </form>
    
    <div class="pagination"><?=$paginate?></div>

<?endif;?>

<script>
    var sort_process = {};
    sort_process.save_sort_url = "<?=relative_url($BC->_getBaseURI()."/sort")?>";
    sort_process.redirect_after_sort_url = "<?=site_url($BC->_getBaseURI())?>";
</script>

<?=load_inline_js('inc/js-sort-func')?>