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
		$list[$key] = "<a href='".base_url()."images/data/b/photos/{$record['file_name']}' rel='facebox'>".img('images/data/s/photos/'.$record['file_name']).'</a>';
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



<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<div align="center">
	<?=$gallery_table?>
</div>

<div class="pagination"><?=$paginate?></div>

<?=load_inline_js('inc/js-facebox'); ?>
