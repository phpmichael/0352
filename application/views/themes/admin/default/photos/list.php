<!--Load JS-->
<?php $this->load->view('inc/js-select_all'); ?>
<!--Load JS-->

<?=form_open($BC->_getBaseURI())?>
<div align="right">
<table>
<tr>
	<?if(userAccess('photos_categories','view')):?><td><?=form_dropdown("category_id",$categories,$this->session->userdata($BC->_getCurrentTable().'_category_id'),"class='select'")?></td><?endif?>
	<td><?=language('photo_name')?>:</td>
	<td><?=form_hidden("search_by","orig_name");?></td>
	<td><?=form_input("keyword",$this->session->userdata($BC->_getCurrentTable().'_keyword'),"class='input'");?></td>
	<td><?=form_submit("submit",language('search'));?></td>
	<td><input type="reset" value="<?=language('reset')?>" onclick="location.href='<?=site_url($BC->_getBaseURI()."/index/reset")?>'"></td>
</tr>
</table>
</div>
</form>

<?=br(2)?>

<?if($query->num_rows()>0):?>

    <p>
        <?//link for delete selected records?>
        <?=anchor__Delete_Selected()?>
        
        <?if(userAccess('photos','edit')):?>
            |
            <a href="javascript:void(0)" id="bulk_change_category"><?=language('change_category')?></a>
        <?endif?>
    </p>
    
    <?//lopen form for delete records?>
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


<?$this->load->view('inc/js-facebox'); ?>

<script>

$j(document).ready(function(){
    $j("#bulk_change_category").click(function(){
        var category_id = parseInt( $j('select[name=category_id]').val() );//get category from search form
        if(category_id) //check if category selected
        {
            $j('input[name=new_category_id]').val( category_id ); 
            $j('form[name=form]').attr('action','<?=aurl('bulk_change_category')?>').submit();
        }
        else alert("<?=language('choose_category')?>");
    });
});

</script>