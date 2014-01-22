<!--Load JS-->
<?php $this->load->view('inc/js-select_all'); ?>
<!--Load JS-->

<!--Load Search Form-->
<?php 
$fields_names = array('subject','message','send_to');
load_theme_view('inc/form-search',array('fields_names'=>$fields_names));
?>
<!--Load Search Form-->

<?=br(2)?>

<?if($query->num_rows()>0):?>

    <div align="center"><p><b><?=language('newsletters_in_queue')?></b></p></div>

    <p><?=anchor__Delete_Selected()?> | <a href="javascript:void(0)" onclick="clearTimeout(massmailTimeout); $j(this).hide()"><?=language('stop_massmail')?></a></p>
    
    <?//lopen form for delete records?>
    <?=aform_open__Delete_Selected()?>
    
    <?//set ouput format
    $cols = array(
        array(
            'field' => 'id',
            'width' => 50
        ),
        array(
            'field'=>'subject'
        ),
        array(
            'field'=>'send_to'
        ),
        array(
            'field'=>'date'
        )
    );
    
    $rows = $query->result_array();
    
    show_records_table($cols,$rows,FALSE,FALSE);
    ?>
    
    </form>
    
    <div class="pagination"><?=$paginate?></div>
<?else:?>
    <b><?=language('empty_queue')?></b>
<?endif;?>

<?if($query->num_rows()>0):?>
<script>
var massmailTimeout = setTimeout(function(){location.reload()},1000*<?=$BC->settings_model['newsletters_send_interval']?>);
</script>
<?endif;?>