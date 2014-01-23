<?foreach ($this->formbuilder_model->getIncludes() as $include):?>
	<?if( in_array($include,array('js-multilang-help-tools')) ):?>
		<?load_theme_view('inc/'.$include)?>
	<?else:?>
		<?=load_inline_js('inc/'.$include)?>
	<?endif?>
<?endforeach?>

<?=include_js($BC->_getFolder('js').'custom/fb/process.js')?>