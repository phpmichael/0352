<?if($BC->formbuilder_model->getFormMode()=='edit' || $item['main_type']!='input' || $item['value'] ):?>

	<?if( $item['main_type']=='input' && stristr($item['name'],"[LANG]") ):?>
	    
		<?if($BC->formbuilder_model->getFormMode()=='edit'):?>	
			<ul>
			<?foreach (get_multilang_codes() as $lang_code):
				$multilang_item = $item; 
				$multilang_item['name'] = str_replace("[LANG]","[{$lang_code}]",$item['name']); 
				$multilang_item['label'] = $item['label']." ({$lang_code})"; 
				$multilang_item['value'] = (isset($item['value'][$lang_code]))? $item['value'][$lang_code] : ''; 
			?>
				<li>
			        <?load_theme_view($BC->formbuilder_model->getScreensPath().$item['main_type'].'/'.$item['type'],array('item'=>$multilang_item))?>
			        <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?>
				</li>
			<?endforeach?>
			</ul>
		<?else:?>
			<?$item['value'] = $item['value'][strtoupper($BC->_getInterfaceLang(TRUE))]?>
			<?load_theme_view($BC->formbuilder_model->getScreensPath().$item['main_type'].'/'.$item['type'],array('item'=>$item))?>
		<?endif?>
	
	<?else:?>
	    <?load_theme_view($BC->formbuilder_model->getScreensPath().$item['main_type'].'/'.$item['type'],array('item'=>$item))?>
	<?endif?>

<?endif?>