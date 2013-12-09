<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for dashboard.
 * 
 * @package dashboard  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Dashboard_model extends Base_model
{
	//name of table
	protected $c_table = 'dashboard';
	
	/**
	 * Return list of availbale widgets.
	 * Check user rights.
	 *
	 * @return array
	 */
	public function getAvailableWidgets()
	{
		$widgets = $this->generalWidgets();
		
		$sections = $this->CI->groups_model->getAvailableSections('admin');
		    
        foreach ($sections as $section)
		{
			if(userAccess($section,'view'))
			{
				if( ($model = load_model($section.'_model')) && (method_exists($model,'dashboardWidget')) && ($widget = $model->dashboardWidget()) )
				{
					$widgets[] = $widget;
				}
			}
		}
		
		return $widgets;
	}
	
	private function sortSections($sections)
	{
		
	}
	
	/**
	 * Return list of widgets available for all users.
	 *
	 * @return array
	 */
	private function generalWidgets()
	{
		$widgets[1] = $this->selectLangWidget();
		
		return $widgets;
	}
	
	/**
	 * Build widget for change interface language.
	 *
	 * @return array
	 */
	private function selectLangWidget()
	{
		$content = "";
		
		foreach (get_multilang_codes() as $lang_code)
		{
			$content .= "
			<p>
				<a href='".site_url(strtolower($lang_code).'/'.$this->CI->_getFolder().'dashboard')."'>
				  ".img('images/flags/'.strtolower($lang_code).'.png')." ".language($this->CI->lang_model->getLanguageByLangCode($lang_code))."
				</a>
			</p>
			"; 
		}
		
		$widget['title'] = language('language');
    	$widget['content'] = $content;
    	
    	return $widget;
	}
	
}