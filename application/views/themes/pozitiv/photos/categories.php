<?
    // table settings
	$BC->load->library('table');
	
	$tmpl = array (
        'table_open'          => '<table width="100%" border="0" cellpadding="4" cellspacing="0">',

        'heading_row_start'   => '<tr>',
        'heading_row_end'     => '</tr>',
        'heading_cell_start'  => '<th>',
        'heading_cell_end'    => '</th>',

        'row_start'           => '<tr>',
        'row_end'             => '</tr>',
        'cell_start'          => '<td align="center" width="25%">',
        'cell_end'            => '</td>',

        'row_alt_start'       => '<tr>',
        'row_alt_end'         => '</tr>',
        'cell_alt_start'      => '<td align="center"  width="25%">',
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

<div align="center">
	<?=$gallery_table?>
</div>