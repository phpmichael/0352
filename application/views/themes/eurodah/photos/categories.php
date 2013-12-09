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

	foreach ($categories as $category)
	{
		$list[] = anchor($BC->_getBaseURI().'/index/'.$category['id'],img(array('src'=>'images/data/s/photos_categories_list/'.$category['file_name'],'alt'=>htmlspecialchars($category['category']),'width'=>$BC->settings_model['photos_categories_list_small_width'],'height'=>$BC->settings_model['photos_categories_list_small_height']))).' '.$category['category'];
	}

	if(isset($list) && !empty($list)) 
	{
		$list = $BC->table->make_columns($list, 4);
		$gallery_table = $BC->table->generate($list);
	}
	else 
	{
		$gallery_table = "";
	}
?>

<div class="section">                   
                        
   <h1 class="title" id="page-title"><?=$BC->_getPageTitle()?></h1>
                        
   <div id="block-system-main">
      
        <div class="node">
        
          <div class="content">
                
               <?=$gallery_table?>
            
          </div><!-- /.content -->
      
        </div><!-- /.node -->  

    </div><!-- /.block -->  
    
</div>