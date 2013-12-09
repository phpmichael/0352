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
    <?=form_open($BC->_getBaseURI()."/delete_selected/".$this->uri->segment($BC->_getSegmentsOffset()+3),array('name'=>'form'))?>
    
    <?//set ouput format
    $cols = array(
        array(
            'field' => 'photo',
            'width' => $photo_data['small_width'],
            'just_text'=>TRUE
        ),
        array(
            'field' => 'sort',
            'width' => 80,
            'just_text'=>TRUE
        ),
        array(
            'field'=>'category',
            'just_text'=>TRUE
        )
    );
    
    $rows = $query->result_array();
    
    //prepare rows for output
    foreach ($rows as &$row)
    {
        $row['category__output'] = anchor($BC->_getBaseURI().'/index/'.$row['id'],$row['category']);
        $row['photo__output'] = (($row['file_name'])? img('images/data/s/'.$BC->_getCurrentTable().'/'.$row['file_name']."?no_cache=".time()) : '' );
    }
    
    show_records_sortable($cols,$rows);
    ?>
    
    </form>
    
    <div class="pagination"><?=$paginate?></div>

<?endif;?>

<?$this->load->view('inc/js-facebox'); ?>

<?load_theme_view('inc/js-categories-sort')?>