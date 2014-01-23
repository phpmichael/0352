<!--Load JS-->
<?=load_inline_js('inc/js-select_all');?>
<!--Load JS-->

<div class="fl" style="width:50%;">
   <?load_theme_view('inc/tpl-filters');?>
</div>

<!--Load Search Form-->
<?php 
$fields_names = array('name','price');
if(@$BC->settings_model['use_product_sku']) $fields_names[] = 'SKU';
load_theme_view('inc/form-search',array('fields_names'=>$fields_names));
?>
<!--Load Search Form-->


<div class="fr">
    <?load_theme_view('inc/form-whole-prices-update');?>
</div>


<div class="clear"></div>

<br />

<?if($query->num_rows()>0):?>

    <p>
        <?//link for delete selected records?>
        <?=anchor__Delete_Selected()?>
        
        <?load_theme_view('inc/tpl-bulk-stock-featured');?>
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
            'field' => 'image',
            'width' => 100,
            'title'=>language('image')
        )
    );
    
    if(@$BC->settings_model['use_product_sku'])
    {
        $cols[] = array(
            'field'=>'SKU'
        );
    }
    
    $cols[] = array(
                'field'=>'name'
            );
            
    $cols[] = array(
                'field'=>'price',
                'width'=>60
            );
            
    $cols[] = array(
                'field'=>'in_stock',
                'width'=>110
            );
            
    $cols[] = array(
                'field'=>'featured',
                'width'=>110
            );
    
    $rows = $query->result_array();
    
    //show tags if user has rights for this
    if( userAccess('tags','view') ) 
    {
        $tags_model = load_model('tags_model');
        
        $cols[] = array(
            'field'=>'tags',
            'title'=>language('tags'),
            'width'=>80
        );
        
        //prepare rows for output
        foreach ($rows as &$row)
        {
            if($row['image']) $row['image__output'] = "<a href='".base_url().'images/data/b/products/'.$row['image']."' rel='facebox'>".img('images/data/s/products/'.$row['image']."?no_cache=".time())."</a>";
            $row['price__output'] = exchange($row['price']);
            $row['in_stock__output'] = (($row['in_stock'])?language('yes'):language('no'));
            $row['featured__output'] = (($row['featured'])?language('yes'):language('no'));
            $row['tags__output'] = $tags_model->getPostTagsStr($BC->_getCurrentTable(),$row['id']);
            if(userAccess('tags','edit')) $row['tags__output'] .= "<br/>".anchor_admin('edit_tags',$row['id']);
        }
    }
    
    show_records_table($cols,$rows);
    ?>
    
    </form>
    
    <div class="pagination"><?=$paginate?></div>

<?endif;?>

<?=load_inline_js('inc/js-facebox'); ?>