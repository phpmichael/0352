<?
    // table settings
	$BC->load->library('table');
	
	$tmpl = array (
        'table_open'          => '<table width="100%">',

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
		if($category['id']!=1) $list[] = anchor($BC->_getBaseURI().'/index/'.$category['id'],img('images/data/s/photos_categories_list/'.$category['file_name']).'<div>'.$category['category'].'</div>');
	}

	if(isset($list) && !empty($list)) 
	{
		$list = $BC->table->make_columns($list, 3);
		$gallery_table = $BC->table->generate($list);
	}
	else 
	{
		$gallery_table = "";
	}
?>

<div id="gallery">
	<?=$gallery_table?>
</div>