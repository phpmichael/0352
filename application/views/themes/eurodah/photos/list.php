<?
    // table settings
	$BC->load->library('table');
	
	$tmpl = array (
        'table_open'          => '<table id="gallery">',

        'heading_row_start'   => '<tr>',
        'heading_row_end'     => '</tr>',
        'heading_cell_start'  => '<th>',
        'heading_cell_end'    => '</th>',

        'row_start'           => '<tr>',
        'row_end'             => '</tr>',
        'cell_start'          => '<td>',
        'cell_end'            => '</td>',

        'row_alt_start'       => '<tr>',
        'row_alt_end'         => '</tr>',
        'cell_alt_start'      => '<td>',
        'cell_alt_end'        => '</td>',

        'table_close'         => '</table>'
  	);

	$BC->table->set_template($tmpl); 
	
	// --- BUILD TABLE --- //

	foreach ($list as $key=>$record)
	{
		$list[$key] = "<a href='".base_url()."images/data/b/photos/{$record['file_name']}' class='lightbox'>".img('images/data/s/photos/'.$record['file_name']).'</a>';
	}

	if(isset($list) && !empty($list)) 
	{
		$list = $BC->table->make_columns($list, 4);
		$gallery_table = $BC->table->generate($list);
	}
	else 
	{
		$gallery_table = "";
		$paginate = "";
	}
?>



<div class="section">                   
                        
   <h1 class="title" id="page-title"><?=$BC->_getPageTitle()?></h1>
                        
   <div id="block-system-main">
      
        <div class="node">
        
          <div class="content">
                
            <?=$gallery_table?>
            
            <div class="pagination"><?=$paginate?></div>
            
          </div><!-- /.content -->
      
        </div><!-- /.node -->  

    </div><!-- /.block -->  
    
</div>

<?=load_inline_js('inc/js-lightbox'); ?>
