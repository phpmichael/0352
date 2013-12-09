<?
    // table settings
	$BC->load->library('table');
	
    $tmpl = array (
        'table_open'        => '<table id="articles">',
        'cell_start'        => '<td class="cell">',
        'cell_alt_start'    => '<td class="cell">',
  	);

	$BC->table->set_template($tmpl); 
	
	// --- BUILD TABLE --- //
	if(!empty($posts_list)) 
	{
		foreach ($posts_list as $key=>$record)
		{
			$date = date('d/m/Y H:i',strtotime($record->pub_date));
		    
		    $posts_list[$key] = "
			<h3><a href='".post_url($record)."'>".$record->head."</a></h3>
			
			<div class='fl'><i>{$date}</i></div>
			<div class='fr'><i>".comments_number('articles',$record->id)."</i></div>
			
			<div class='clear' align='justify'>
	
				".character_limiter(strip_tags($record->body),260)."
	
				<a href='".post_url($record)."'>".language('read_more')."</a>
	
			</div>
			";
		    
		    //add tags
		    $posts_list[$key] .= load_theme_view('inc/box-post-tags',array('post_id'=>$record->id),TRUE);
		}
	}

	if(isset($posts_list) && !empty($posts_list)) 
	{
		$posts_list = $BC->table->make_columns($posts_list, 2);
		$content_table = $BC->table->generate($posts_list);
	}
	else 
	{
		$content_table = "<h2>".language('search_did_not_give_any_results')."</h2>";
		$paginate = "";
	}
?>

<?php load_theme_view('inc/tpl-cur-location')?>

<h1><?=$BC->_getPageTitle()?></h1>

<?if(isset($search_category_id) && $search_category_id && ($categories_list = $this->articles_categories_model->getChildren($search_category_id)) ):?>
<div id="subcategories-block">

    <h3>Subcategories</h3>
    <ul>
    <?
        foreach ($categories_list as $category_id=>$category)
        {
            echo "<li style='width:50%;float:left;'><h4><a href='".site_url($BC->_getBaseURI()."/index/category/{$category_id}")."'>{$category}</a></h4></li>";
        }
    ?>
    </ul>
    
    <br />
    <br />
    
</div>
<?endif?>

<?=$content_table?>

<div class="pagination"><?=$paginate?></div>