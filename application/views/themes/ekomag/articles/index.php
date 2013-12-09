<?
    // table settings
	$BC->load->library('table');
	
    $tmpl = array (
        'table_open'        => '<table id="articles-list" width="100%">',
        'cell_start'        => '<td>',
        'cell_alt_start'    => '<td>',
  	);

	$BC->table->set_template($tmpl); 
	
	// --- BUILD TABLE --- //
	if(!empty($posts_list)) 
	{
		foreach ($posts_list as $key=>$record)
		{
			$date = date('d/m/Y H:i',strtotime($record->pub_date));
		    
		    $posts_list[$key] = "
			<h2>{$record->head}</h2>
			
			<div class='fl'><i>{$date}</i></div>
			<div class='fr'><i>".comments_number('articles',$record->id)."</i></div>
			
			<div class='clear article-content'>
	
				".word_limiter_more($record->body,80)."
	
				".anchor_base('articles/name/'.$record->slug,language('read_more'))."
	
			</div>
			";
		    
		    //add tags
		    $posts_list[$key] .= load_theme_view('inc/box-post-tags',array('post_id'=>$record->id),TRUE);
		}
	}

	if(isset($posts_list) && !empty($posts_list)) 
	{
		$posts_list = $BC->table->make_columns($posts_list, 1);
		$content_table = $BC->table->generate($posts_list);
	}
	else 
	{
		$content_table = "<h2>".language('search_did_not_give_any_results')."</h2>";
		$paginate = "";
	}
?>

    <h2><?=$BC->_getPageTitle()?></h2>

    <div class="boxIndent">
        <div>
			<form method="post" action="<?=site_url($BC->_getBaseURI())?>">
				<?=form_input("keywords",trim(urldecode(@$keywords)));?>
				<?=form_submit('search',language('search'))?>
			</form>
		</div>
		<br class="clear" />
		
		<?=$content_table?>
		
		<?if($paginate):?>
        <div class="pagination"><p><?=language('page')?>: </p><?=$paginate?></div>
        <?endif?>
		
    </div>