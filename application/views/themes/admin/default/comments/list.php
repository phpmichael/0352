<!--Load JS-->
<?php $this->load->view('inc/js-select_all'); ?>
<!--Load JS-->

<div class="fl" style="width:50%;">
   <?=load_theme_view('inc/tpl-filters');?>
</div>

<!--Load Search Form-->
<?php 
$fields_names = array('comment_author','comment_author_email','comment_author_url','comment_comment');
load_theme_view('inc/form-search',array('fields_names'=>$fields_names));
?>
<!--Load Search Form-->

<div class="clear"></div>

<br />

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
            'field'=>'table'
        ),
        array(
            'field'=>'comment_author'
        ),
        array(
            'field'=>'comment_author_email'
        ),
        /*array(
            'field'=>'comment_author_url'
        ),*/
        array(
            'field'=>'comment_author_ip'
        ),
        array(
            'field'=>'comment_content'
        ),
        array(
            'field'=>'comment_date',
            'width'=>80
        ),
        array(
            'field'=>'comment_approved'
        ),
        array(
            'field'=>'view',
            'title'=>' '
        )
    );
    
    $rows = $query->result_array();
    
    //prepare rows for output
    foreach ($rows as &$row)
    {
        if(in_array($row['table'],array('articles','news')))
        {
            $comment_view_url = $row['table'].'/details/'.$row['post_id'];
        }
        elseif(in_array($row['table'],array('products')))
        {
            $comment_view_url = $row['table'].'/view/'.$row['post_id'];
        }
        
        $row['comment_author__output'] = (($row['customer_id'] && userAccess('customers','edit'))?anchor_base("customers/edit/id/desc/0/".$row['customer_id'],$row['comment_author']):$row['comment_author']);
        $row['comment_content__output'] = word_limiter(strip_tags($row['comment_content']),20);
        $row['comment_date__output'] = date('Y-m-d H:i',strtotime($row['comment_date']));
        $row['comment_approved__output'] = (($row['comment_approved'])?language('yes'):language('no'));
        $row['view__output'] = "<a href='".site_url($BC->_getInterfaceLang().'/'.$comment_view_url)."#comment-".$row['id']."' class='view-record' title='".language('view')."' target='_blank'>".language('view')."</a>";
    }
    
    show_records_table($cols,$rows);
    ?>
    
    </form>
    
    <div class="pagination"><?=$paginate?></div>

<?endif;?>