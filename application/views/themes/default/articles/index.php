<?
    // table settings
	$BC->load->library('table');
	
    $tmpl = array (
        'table_open'        => '<table id="articles">',
        'cell_start'        => '<td width="50%">',
        'cell_alt_start'    => '<td width="50%">',
  	);

	$BC->table->set_template($tmpl); 
	
	// --- BUILD TABLE --- //
	if(!empty($posts_list)) 
	{
		foreach ($posts_list as $key=>$record)
		{
			$date = date('d/m/Y H:i',strtotime($record->pub_date));
		    
		    $posts_list[$key] = "
			<h3>{$record->head}</h3>
			
			<div class='fl'><i>{$date}</i></div>
			<div class='fr'><i>".comments_number('articles',$record->id)."</i></div>
			
			<div class='clear' align='justify'>
	
				".character_limiter(strip_tags($record->body),260)."
	
				<a href='".site_url($BC->_getBaseURI().'/name/'.$record->slug)."'>".language('read_more')."</a>
	
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

<h2><?=$BC->_getPageTitle()?></h2>

<div align="right">
	<form method="post" action="<?=site_url($BC->_getBaseURI())?>">
		<?=form_input("keywords",trim(urldecode(@$keywords)));?>
		<?=form_submit("submit",language('search'));?>
	</form>
</div>

<?=$content_table?>

<div class="pagination"><?=$paginate?></div>