<?
    // table settings
	$BC->load->library('table');
	
    $tmpl = array (
        'table_open'        => '<table id="articles" class="data-table">',
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
			<h2>{$record->head}</h2>
			
			<div class='fl'><i>{$date}</i></div>
			<div class='fr'><i>".comments_number('articles',$record->id)."</i></div>
			
			<div class='clear content' align='justify'>
	
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

<div class="main-block">
    <div class="top-corners"><div><div>&nbsp;</div></div></div>

    <div class="corner">
        <div class="full-width">
            <div class="page-title">
                <h1><?=$BC->_getPageTitle()?></h1>
            </div>

			<div>
				<form method="post" action="<?=site_url($BC->_getBaseURI())?>">
					<?=form_input("keywords",trim(urldecode(@$keywords)));?>
					<button type="submit" title="<?=language('search')?>" class="button"><span><span><?=language('search')?></span></span></button>
				</form>
			</div>
			<br class="clear" />
			
			<?if(@trim(urldecode($keywords))):?>
            <div class="search-results-for">
                <h2><?=language('search_results_for')?>: " <i><?=trim(urldecode($keywords))?></i> "</h2>
            </div>
            <?elseif(@trim(urldecode($tag))):?>
            <div class="search-results-for">
                <h2><?=language('products_with_tag')?>: " <i><?=trim(urldecode($tag))?></i> "</h2>
            </div>
            <?endif?>
			
			<?=$content_table?>
			
			<br class="clear" />
			
			<div class="pagination"><?=$paginate?></div>
			
		</div>
    </div>

    <div class="bot-corners"><div><div>&nbsp;</div></div></div>
</div>