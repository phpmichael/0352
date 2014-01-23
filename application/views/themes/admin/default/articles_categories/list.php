<!--Load JS-->
<?=load_inline_js('inc/js-select_all'); ?>
<?=load_inline_js('inc/js-jquery-ui'); ?>
<!--Load JS-->

<?if($query->num_rows()>0):?>

    <?//link for delete selected records?>
    <p><?=anchor__Delete_Selected()?></p>
    
    <?if(userAccess($BC->_getController(),'edit')):?>
    <p><a id="save" href="javascript:void(0)"><?=language('save_sorting')?></a></p>
    <?endif?>
    
    <?//lopen form for delete records?>
    <?=form_open($BC->_getBaseURI()."/delete_selected/".$this->uri->segment($BC->_getSegmentsOffset()+3),array('name'=>'form'))?>
    
    <?//set ouput format
    $cols = array(
        array(
            'field' => 'sort',
            'width' => 80,
            'just_text'=>TRUE,
        ),
        array(
            'field'=>'category',
            'just_text'=>TRUE,
        )
    );
    
    $rows = $query->result_array();
    
    //prepare rows for output
    foreach ($rows as &$row)
    {
        $row['category__output'] = anchor($BC->_getBaseURI().'/index/'.$row['id'],$row['category']);
    }
    
    show_records_sortable($cols,$rows);
    ?>
    
    </form>
    
    <div class="pagination"><?=$paginate?></div>

<?endif;?>

<?load_theme_view('inc/js-categories-sort')?>