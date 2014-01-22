<!--Load JS-->
<?php $this->load->view('inc/js-select_all'); ?>
<?php $this->load->view('inc/js-jquery-ui'); ?>
<!--Load JS-->

<?=br(2)?>

<? 
$filter_id = $this->uri->segment($BC->_getSegmentsOffset()+3);
?>

<p>
<?=anchor($BC->_getBaseURI(),language('filters_groups'))?> 
<?if(userAccess($BC->_getController(),'edit')):?>
| <?=anchor($BC->_getBaseURI().'/edit/id/asc/0/'.$filter_group_id,language('edit_filter_group'))?>
<?endif?>
<?if(userAccess($BC->_getController(),'add')):?>
| <?=anchor($BC->_getBaseURI().'/filters_add/'.$filter_group_id,language('add_filter'))?>
<?endif?>
</p>

<br />

<?if(!empty($filters)):?>

    <?//link for delete selected records?>
    <p>
        <?=anchor__Delete_Selected()?>
        
        <?if(userAccess($BC->_getController(),'edit') && !isset($deny_sortable)):?>
        | <a id="save" href="javascript:void(0)"><?=language('save_sorting')?></a>
        <?endif?>
    </p>
        
    <?//lopen form for delete records?>
    <?=form_open($BC->_getBaseURI()."/delete_selected_filters/".$filter_group_id,array('name'=>'form'))?>
    
    <?//set ouput format
    $cols = array(
        array(
            'field' => 'sort',
            'width' => 80,
            'just_text'=>TRUE
        ),
        array(
            'field'=>'title',
            'just_text'=>TRUE
        ),
        array(
            'field'=>'code',
            'just_text'=>TRUE,
            'width'=>350
        ),
        array(
            'field'=>'active',
            'just_text'=>TRUE,
            'width'=>120
        ),
        array(
            'field'=>'panel',
            'just_text'=>TRUE,
            'width'=>80
        ),
        array(
            'field'=>'filter_edit',
            'title'=>' ',
            'width'=>100
        )
    );
    
    $rows = $filters;
    
    //prepare rows for output
    foreach ($rows as &$row)
    {
        $row['active__output'] = (($row['active'])?language('yes'):language('no'));
        $row['filter_edit__output'] = anchor_admin('filters_edit',$row['id']);
    }
    
    show_records_sortable($cols,$rows,FALSE,FALSE);
    ?>
    
    </form>

<?endif;?>

<script>
//<![CDATA[
var sort_process = {};
sort_process.save_sort_url = "<?=relative_url($BC->_getBaseURI()."/sort_filters/".$this->uri->segment($BC->_getSegmentsOffset()+3))?>";
sort_process.redirect_after_sort_url = "<?=site_url($BC->_getBaseURI()."/filters_list/".$this->uri->segment($BC->_getSegmentsOffset()+3))?>";
//]]>
</script>

<?load_theme_view('inc/js-sort-func')?>