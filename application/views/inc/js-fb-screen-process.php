<?foreach ($this->formbuilder_model->getIncludes() as $include):?>
    <?=load_inline_js('inc/'.$include)?>
<?endforeach?>

<?=include_js($BC->_getFolder('js').'custom/fb/process.js')?>