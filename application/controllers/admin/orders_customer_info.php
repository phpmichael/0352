<?php
require_once(APPPATH.'controllers/abstract/admin_fb.php');

/** 
 * This is admin controller for customer info filled during order.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2017
 * @access public
 */
class Orders_customer_info extends Admin_fb
{
	protected $process_form_html_id = "orders_customer_info";

	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //

    /**
     * Edit Item.
     *
     * @return void
     */
    public function Edit()
    {
        //TODO: check if need Novaposhta script before include this
        // === CSS Styles === //
        $this->css_files[] = 'js/jquery/ui/1.10.4/themes/smoothness/jquery-ui.min.css';
        // === JS Styles === //
        $this->js_files[] = 'js/jquery/ui/1.10.4/jquery-ui.min.js';
        $this->js_files[] = 'js/custom/shipping/novaposhta/find.js';

        parent::Edit();
    }

}