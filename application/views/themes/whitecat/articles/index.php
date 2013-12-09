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
			<h2>{$record->head}</h2>
			
			<div class='fl'><i>{$date}</i></div>
			<div class='fr'><i>".comments_number('articles',$record->id)."</i></div>
			
			<div class='clear' align='justify'>
	
				<p>".character_limiter(strip_tags($record->body),260)."
	
				<a href='".site_url($BC->_getBaseURI().'/name/'.$record->slug)."'>".language('read_more')."</a>
				
				</p>
	
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

<div id="page">
    <h2 class="title"><span><span><?=$BC->_getPageTitle()?></span></span></h2>

    <div class="boxIndent">
        <div class="wrapper">
            <div class="content">
                <div>
    				<form method="post" action="<?=site_url($BC->_getBaseURI())?>">
    					<?=form_input("keywords",trim(urldecode(@$keywords)));?>
    					<button type="submit" title="<?=language('search')?>" class="button"><span><span><?=language('search')?></span></span></button>
    				</form>
    			</div>
    			<br class="clear" />
    			
    			<?if(@trim(urldecode($keywords))):?>
                <div class="search-results-for">
                    <h4><?=language('search_results_for')?>: " <i><?=trim(urldecode($keywords))?></i> "</h4>
                </div>
                <?elseif(@trim(urldecode($tag))):?>
                <div class="search-results-for">
                    <h4><?=language('products_with_tag')?>: " <i><?=trim(urldecode($tag))?></i> "</h4>
                </div>
                <?endif?>
    			
    			<?=$content_table?>
    			
    			<?if($paginate):?>
                <div class="pagination"><p><?=language('page')?>: </p><?=$paginate?></div>
                <?endif?>
    			
    			<br class="clear" />
            </div>
        </div>
    </div>
</div>