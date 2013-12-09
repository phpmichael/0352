<?foreach ($this->formbuilder_model->getIncludes() as $include):?>
	<?if( in_array($include,array('js-multilang-help-tools')) ):?>
		<?load_theme_view('inc/'.$include)?>
	<?else:?>
		<?$this->load->view('inc/'.$include)?>
	<?endif?>
<?endforeach?>

<?=include_js($BC->_getFolder('js').'custom/fb/process.js')?>