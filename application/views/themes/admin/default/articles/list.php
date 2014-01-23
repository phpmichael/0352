<!--Load JS-->
<?=load_inline_js('inc/js-select_all'); ?>
<!--Load JS-->

<!--Load Search Form-->
<?php 
$fields_names = array('head','slug','body','author','source');
load_theme_view('inc/form-search',array('fields_names'=>$fields_names));
?>
<!--Load Search Form-->

<?=br(2)?>

<?if($query->num_rows()>0):?>

    <?//link for delete selected records?>
    <p><?=anchor__Delete_Selected()?></p>
    
    <?//lopen form for delete records?>
    <?=aform_open__Delete_Selected()?>
    
    <?//set ouput format
    $cols = array(
        array(
            'field' => 'id',
            'width' => 50
        ),
        array(
            'field'=>'head'
        ),
        array(
            'field'=>'author'
        ),
        array(
            'field'=>'source'
        )
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
            $row['tags__output'] = $tags_model->getPostTagsStr($BC->_getCurrentTable(),$row['id']);
            if(userAccess('tags','edit')) $row['tags__output'] .= "<br/>".anchor_admin('edit_tags',$row['id']);
        }
    }
    
    show_records_table($cols,$rows);
    ?>
    
    </form>
    
    <div class="pagination"><?=$paginate?></div>

<?endif;?>