<!--Load JS-->
<?=load_inline_js('inc/js-select_all'); ?>
<!--Load JS-->

<? 
$form_id = $this->uri->segment($BC->_getSegmentsOffset()+3);
$container_id = $this->uri->segment($BC->_getSegmentsOffset()+4);
?>

<p>
<?=anchor($BC->_getBaseURI(),'Forms')?> 
<?if(userAccess($BC->_getController(),'edit')):?>
| <?=anchor($BC->_getBaseURI().'/edit/id/asc/0/'.$form_id,'Edit Form')?>
<?endif?>
<?if(userAccess($BC->_getController(),'add')):?>
| <?=anchor($BC->_getBaseURI().'/containers_add/'.$form_id.'/'.$container_id,'Add Container')?>
<?endif?>
<?if(userAccess($BC->_getController(),'add') && $container_id):?>
| <?=anchor($BC->_getBaseURI().'/inputs_add/'.$form_id.'/'.$container_id,'Add Input')?>
<?endif?>
</p>

<?if($query->num_rows()>0):?>

    <?//link for delete selected records?>
    <p><?//=anchor__Delete_Selected()?></p>
    
    <?//lopen form for delete records?>
    <?=aform_open__Delete_Selected()?>
    
    <?//set ouput format
    $cols = array(
        array(
            'field' => 'html_id',
            'width' => 200,
            'just_text'=>TRUE
        ),
        array(
            'field' => 'name',
            'width' => 200,
            'just_text'=>TRUE
        ),
        array(
            'field'=>'label',
            'just_text'=>TRUE
        ),
        array(
            'field'=>'input_edit',
            'title'=>' ',
            'width'=>100
        )
    );
    
    $rows = $query->result_array();
    
    //prepare rows for output
    foreach ($rows as &$row)
    {
        $row['input_edit__output'] = anchor_admin('inputs_edit',$row['id']);
    }
    
    show_records_table($cols,$rows,FALSE,FALSE);
    ?>
    
    </form>
    
    <div class="pagination"><?=$paginate?></div>

<?endif;?>