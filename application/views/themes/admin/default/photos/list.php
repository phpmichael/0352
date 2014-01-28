<!--Load JS-->
<?=load_inline_js('inc/js-select_all'); ?>
<!--Load JS-->

<!--Load Search Form-->
<?php
$fields_names = array('orig_name');
load_theme_view('inc/form-search',array('fields_names'=>$fields_names, 'search_category_table'=>'photos_categories'));
?>
<!--Load Search Form-->

<div class="clear"></div>

<br />

<?if($query->num_rows()>0):?>

    <p>
        <?//link for delete selected records?>
        <?=anchor__Delete_Selected()?>
        
        <?if(userAccess('photos','edit')):?>
            |
            <a href="javascript:void(0)" id="bulk_change_category"><?=language('change_category')?></a>
        <?endif?>
    </p>
    
    <?//open form for delete records?>
    <?=aform_open__Delete_Selected()?>
    <?=form_hidden('new_category_id')?>
    
    <?//set ouput format
    $cols = array(
        array(
            'field' => 'image',
            'width' => $photo_data['small_width'],
            'title'=>' '
        ),
        array(
            'field' => 'id',
            'width' => 50
        ),
        array(
            'field'=>'orig_name'
        ),
        array(
            'field'=>'date',
            'width'=>80
        )
    );
    
    if(userAccess('photos_categories','view')) 
    $cols[] = array(
            'field'=>'category_id',
            'width'=>80
        );
    
    //show tags if user has rights for this
    if( userAccess('tags','view') ) 
    {
        $tags_model = load_model('tags_model');
        
        $cols[] = array(
            'field'=>'tags',
            'title'=>language('tags'),
            'width'=>80
        );
    }
    
    $categories_model = load_model('photos_categories_model');
    
    $rows = $query->result_array();
    
    //prepare rows for output
    foreach ($rows as &$row)
    {
        $row['image__output'] = "<a href='".base_url()."images/data/b/photos/".$row['file_name']."' rel='facebox'>".img('images/data/s/photos/'.$row['file_name']."?no_cache=".time())."</a>";
        if(userAccess('photos_categories','view')) $row['category_id__output'] = $categories_model->getTitle($row['category_id']).' <br /> '.anchor_admin('change_category',$row['id']);
        if(userAccess('tags','view')) $row['tags__output'] = $tags_model->getPostTagsStr($BC->_getCurrentTable(),$row['id']);
        if(userAccess('tags','edit')) $row['tags__output'] .= "<br/>".anchor_admin('edit_tags',$row['id']);
    }
    
    show_records_table($cols,$rows,FALSE,FALSE);
    ?>
    
    </form>
    
    <div class="pagination"><?=$paginate?></div>

<?endif;?>


<?=load_inline_js('inc/js-facebox'); ?>

<?=load_inline_js('inc/js-bulk-change-category'); ?>
