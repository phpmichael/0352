<!--Load JS-->
<?php $this->load->view('inc/js-select_all'); ?>
<?php $this->load->view('inc/js-jquery-ui'); ?>
<!--Load JS-->

<!--Load Search Form-->
<?php 
$fields_names = array('title','section');
load_theme_view('inc/form-search',array('fields_names'=>$fields_names));
?>
<!--Load Search Form-->

<?=br(2)?>

<?if($query->num_rows()>0):?>

    <?//link for delete selected records?>
    <p>
        <?=anchor__Delete_Selected()?>
        
        <?if(userAccess($BC->_getController(),'edit') && !isset($deny_sortable)):?>
        | <a id="save" href="javascript:void(0)"><?=language('save_sorting')?></a>
        <?endif?>
    </p>
    
    
    
    <?//lopen form for delete records?>
    <?=form_open($BC->_getBaseURI()."/delete_selected_groups",array('name'=>'form'))?>
    
    <?//set ouput format
    $cols = array(
        array(
            'field' => 'sort',
            'width' => 80,
            'just_text'=>TRUE
        ),
        array(
            'field'=>'section',
            'width'=>230,
        ),
        array(
            'field'=>'title'
        ),
        array(
            'field'=>'active',
            'width'=>120
        ),
        array(
            'field'=>'connector',
            'width'=>120
        )
    );
    
    $rows = $query->result_array();
    
    //prepare rows for output
    foreach ($rows as &$row)
    {
        $row['title__output'] = anchor($BC->_getBaseURI().'/filters_list/'.$row['id'],$row['title']);
        $row['active__output'] = (($row['active'])?language('yes'):language('no'));
    }
    
    show_records_sortable($cols,$rows);
    ?>
    
    </form>
    
    <div class="pagination"><?=$paginate?></div>

<?endif;?>

<script type="text/javascript">
//<![CDATA[
var sort_process = {};
sort_process.save_sort_url = "<?=relative_url($BC->_getBaseURI()."/sort_groups")?>";
sort_process.redirect_after_sort_url = "<?=site_url($BC->_getBaseURI()."/index")?>";
//]]>
</script>

<?load_theme_view('inc/js-sort-func')?>