<!--Load JS-->
<?php $this->load->view('inc/js-select_all'); ?>
<?php $this->load->view('inc/js-jquery-ui'); ?>
<!--Load JS-->

<?if($query->num_rows()>0):?>

    <?//link for delete selected records?>
    <p>
        <?=anchor__Delete_Selected()?>
        
        <?if(userAccess($BC->_getController(),'edit') && !isset($deny_sortable)):?>
        | <a id="save" href="javascript:void(0)"><?=language('save_sorting')?></a>
        <?endif?>
    </p>
    
    <?//lopen form for delete records?>
    <?=form_open($BC->_getBaseURI()."/delete_selected/".$BC->_getMethod(),array('name'=>'form'))?>
    
    <?//set ouput format
    $cols = array(
        array(
            'field' => 'sort',
            'width' => 80,
            'just_text'=>TRUE
        ),
        array(
            'field'=>'name',
            'just_text'=>TRUE,
            'width'=>280
        ),
        array(
            'field'=>'link',
            'just_text'=>TRUE
        )
    );
    
    $rows = $query->result_array();
    
    show_records_sortable($cols,$rows);
    ?>
    
    </form>
    
    <div class="pagination"><?=$paginate?></div>

<?endif;?>

<script type="text/javascript">
//<![CDATA[
var sort_process = {};
sort_process.save_sort_url = "<?=relative_url($BC->_getBaseURI()."/sort/".$menu)?>";
sort_process.redirect_after_sort_url = "<?=site_url($BC->_getBaseURI()."/$menu")?>";
//]]>
</script>

<?load_theme_view('inc/js-sort-func')?>