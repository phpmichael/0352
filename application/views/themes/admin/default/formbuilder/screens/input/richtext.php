<?$item['html_class'] = (($item['html_class'])? $item['html_class'].' richtext':'richtext')?>
<?load_theme_view($BC->formbuilder_model->getScreensPath().'input/textarea',array('item'=>$item))?>