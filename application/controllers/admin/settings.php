<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for settings.
 * 
 * @package settings  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Settings extends Admin 
{
	//name of table
	protected $c_table = "settings";

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Settings
     */
	public function __construct()
	{
		parent::__construct();	
		
		// === Check is logged manager === //
		$this->_CheckLogged();
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin','settings'));
		
		// === Labels === //
		$this->fields_titles['site_title'] = language('site_title');
		$this->fields_titles['send_email_from'] = language('send_email_from');
		$this->fields_titles['site_email'] = language('site_email');
		
		$this->fields_titles['meta_keywords'] = language('meta_keywords');
		$this->fields_titles['meta_description'] = language('meta_description');
		
		$this->fields_titles['default_lang'] = language('default_language');
		
		$this->fields_titles['admin_theme'] = language('backend');
		$this->fields_titles['front_theme'] = language('frontend');
		
		$this->fields_titles['use_product_sku'] = language('use_product_sku');
		
		$this->fields_titles['poll_check_by_cookie'] = language('check_by_cookie');
		$this->fields_titles['poll_check_by_ip'] = language('check_by_ip');
		$this->fields_titles['poll_check_by_id'] = language('check_by_id');
		
		$this->fields_titles['ratings_check_by_cookie'] = language('check_by_cookie');
		$this->fields_titles['ratings_check_by_ip'] = language('check_by_ip');
		$this->fields_titles['ratings_check_by_id'] = language('check_by_id');
		
		$this->fields_titles['ratings_for_articles_allowed'] = language('ratings_for_articles_allowed');
		$this->fields_titles['ratings_for_news_allowed'] = language('ratings_for_news_allowed');
		$this->fields_titles['ratings_for_comments_allowed'] = language('ratings_for_comments_allowed');
		$this->fields_titles['ratings_for_products_allowed'] = language('ratings_for_products_allowed');
		$this->fields_titles['ratings_for_photos_allowed'] = language('ratings_for_photos_allowed');
		$this->fields_titles['ratings_for_companies_allowed'] = language('ratings_for_companies_allowed');
		$this->fields_titles['ratings_for_customers_allowed'] = language('ratings_for_customers_allowed');
		
		$this->fields_titles['comments_for_articles_allowed'] = language('comments_for_articles_allowed');
		$this->fields_titles['comments_for_news_allowed'] = language('comments_for_news_allowed');
		$this->fields_titles['comments_for_products_allowed'] = language('comments_for_products_allowed');
		$this->fields_titles['automatic_approve_comments'] = language('automatic_approve_comments');
		$this->fields_titles['comments_censor_list'] = language('censor');
		$this->fields_titles['ip_blacklist'] = language('ip_blacklist');
		
		$this->fields_titles['gallery_per_page'] = language('amount_per_page');
		$this->fields_titles['gallery_table_cols'] = language('amount_table_cols');
		
		$this->fields_titles['photos_big_dir'] = language('folder_for_big');
		$this->fields_titles['photos_small_dir'] = language('folder_for_small');
		$this->fields_titles['photos_big_width'] = language('width_of_big');
		$this->fields_titles['photos_big_height'] = language('height_of_big');
		$this->fields_titles['photos_big_crop'] = language('crop_big');
		$this->fields_titles['photos_small_width'] = language('width_of_small');
		$this->fields_titles['photos_small_height'] = language('height_of_small');
		$this->fields_titles['photos_small_crop'] = language('crop_small');
		
		$this->fields_titles['site_phone1'] = language('phone').' 1';
		$this->fields_titles['site_phone2'] = language('phone').' 2';
		$this->fields_titles['site_phone3'] = language('phone').' 3';
		
		$this->fields_titles['newsletters_send_count'] = language('send_count_of_emails');
		$this->fields_titles['newsletters_send_interval'] = language('send_interval').' ('.language('seconds').')';
		
		// === Page Titles === //
		$this->page_titles['index'] = language('settings');
		//default page title
		$this->_setDefaultPageTitle();
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	/**
	 * Build right top admin menu.
	 * Overrides parent method.
	 * 
	 * @return string
	 */
	public function _built_right_menu()
	{
		return '';
	}
	
	/**
	 * Validate and update settings.
	 * 
	 * @return void
	 */
	private function _processInsert()
	{
		$settings = $this->settings_model;
		
		$this->load->library('form_validation');
		
		$configValidation = array(
               array(
                     'field'   => 'site_email', 
                     'label'   => parent::_getFieldTitle('site_email'), 
                     'rules'   => 'trim|required|max_length[255]|valid_email'
                  )
            );
            
        foreach (get_multilang_codes() as $lang_code)
        {      
           $configValidation[] = array(
                     'field'   => "site_title_{$lang_code}", 
                     'label'   => parent::_getFieldTitle('site_title')." ({$lang_code})",
                     'rules'   => 'trim|required|min_length[5]|max_length[255]|xss_clean'
                  );
                  
           $configValidation[] = array(
                     'field'   => "meta_keywords_{$lang_code}", 
                     'label'   => parent::_getFieldTitle('meta_keywords')." ({$lang_code})",
                     'rules'   => 'trim|max_length[255]|xss_clean'
                  );
                  
           $configValidation[] = array(
                     'field'   => "meta_description_{$lang_code}", 
                     'label'   => parent::_getFieldTitle('meta_description')." ({$lang_code})",
                     'rules'   => 'trim|xss_clean'
                  );
            
        }

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() == FALSE)
		{
			parent::_OnOutput($settings->toArray());
		}
		else
		{
			foreach ($this->input->post() as $param=>$value)
			{
			    if($param!='submit') $settings[$param] = $this->input->post($param);
			}
			
			parent::_OnOutput($settings->toArray());
		}
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Call _processInsert.
	 *
	 */
	public function Index()
	{
		$this->_processInsert();
	}
}