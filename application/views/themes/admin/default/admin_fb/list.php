<?if(!isset($big_dir)) $big_dir = 'b/'?>

<!--Load JS-->
<?=load_inline_js('inc/js-select_all'); ?>
<!--Load JS-->

<div class="fl" style="width:50%;">
   <?load_theme_view('inc/tpl-filters');?>
</div>

<!--Load Search Form-->
<?php 
$fields_names = array_keys($BC->formbuilder_model->getFieldsList($BC->_getProcessFormId()));
load_theme_view('inc/form-search',array('fields_names'=>$fields_names, 'search_category_table'=>@$search_category_table));
?>
<!--Load Search Form-->

<?if(isset($whole_price_update)):?>
<div class="fr">
    <?load_theme_view('inc/form-whole-prices-update');?>
</div>
<?endif?>

<div class="clear"></div>

<?=br(2)?>

<?if($query->num_rows()>0):?>

    <p>
    	<?//link for delete selected records?>
    	<?=anchor__Delete_Selected()?>
    	
    	<?if(isset($bulk_stock_featured)):?>
    		<?load_theme_view('inc/tpl-bulk-stock-featured');?>
    	<?endif?>
    </p>
    
    <?//lopen form for delete records?>
    <?=aform_open__Delete_Selected()?>
    
    <?
    $cols = $BC->formbuilder_model->getColsList($BC->_getProcessFormId());
    
    $rows = $query->result_array();
    
    //prepare rows for output
    foreach ($rows as &$row)
    {
        foreach ($cols as $key=>$col)
        {
            if( $col['field']=='data_key' ) unset($cols[$key]);
        	
        	//if image
            if( preg_match("/\.(jpg|jpeg|png|gif)$/i",$row[$col['field']]) ) 
            {
                $row[$col['field'].'__output'] = "<a href='".base_url().'images/data/'.$big_dir.$BC->_getCurrentTable().'/'.$row[$col['field']]."' rel='facebox'>".img('images/data/s/'.$BC->_getCurrentTable().'/'.$row[$col['field']]."?no_cache=".time())."</a>";
            }
            //if time
            elseif( preg_match("/^\d{2}:\d{2}:00$/",$row[$col['field']]) )
            {
                $row[$col['field'].'__output'] = substr($row[$col['field']],0,5);
            }
            //if answerset
            elseif( preg_match("/^a_\d+$/",$row[$col['field']]) )
            {
                $row[$col['field'].'__output'] = fb_answers($row[$col['field']]);
            }
        }
    }
    
    if(!isset($moreAdminLinks)) $moreAdminLinks = array();
    
    show_records_table($cols,$rows,FALSE,TRUE,TRUE,$moreAdminLinks);
    ?>
    
    </form>
    
    <div class="pagination"><?=$paginate?></div>

<?endif;?>

<?=load_inline_js('inc/js-facebox'); ?>