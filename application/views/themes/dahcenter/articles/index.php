<div class="section">                   
                        
   <h1 class="title" id="page-title"><?=$BC->_getPageTitle()?></h1>
                        
   <div id="block-system-main">
      
        <div class="node">
        
          <div class="content">
                
                <?
				    // table settings
					$BC->load->library('table');
					
				    $tmpl = array (
				        'table_open'        => '<table id="articles">',
				        'cell_start'        => '<td style="width:50%">',
				        'cell_alt_start'    => '<td style="width:50%">',
				  	);
				
					$BC->table->set_template($tmpl); 
					
					// --- BUILD TABLE --- //
					if(!empty($posts_list)) 
					{
						foreach ($posts_list as $key=>$record)
						{
							$date = date('d/m/Y H:i',strtotime($record->pub_date));
						    
						    $posts_list[$key] = "
							<h2>".anchor($BC->_getBaseURI().'/name/'.$record->slug,$record->head)."</h2>
							
							<div class='fl submitted'>{$date}</div>
							<div class='fr'><a href='".site_url($BC->_getBaseURI().'/name/'.$record->slug)."#comments' class='comments-number'>".comments_number('articles',$record->id)."</a></div>
							
							<p class='clear'>
					
								".character_limiter(strip_tags($record->body),300)."
					
								<a href='".site_url($BC->_getBaseURI().'/name/'.$record->slug)."' class='more'>".language('read_more')."</a>
					
							</p>
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
				
				<div style="text-align:right">
					<form method="post" action="<?=site_url($BC->_getBaseURI())?>">
						<?=form_input("keywords",trim(urldecode(@$keywords)));?>
						<?=form_submit("submit",language('search'));?>
					</form>
				</div>
				
				<?=$content_table?>
				
				<div class="pagination"><?=$paginate?></div>
            
          </div><!-- /.content -->
      
        </div><!-- /.node -->  

    </div><!-- /.block -->  
    
</div>