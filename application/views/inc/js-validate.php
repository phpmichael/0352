<?=include_js($BC->_getFolder('js').'jquery/validate/jquery.validate.min.js')?>
<?$lang = $BC->_getInterfaceLang(TRUE); if($lang!='en'):?>
<?=include_js($BC->_getFolder('js').'jquery/validate/localization/messages_'.$lang.'.js')?>
<?endif?>