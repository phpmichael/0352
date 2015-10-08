<?php
require_once(APPPATH.'controllers/abstract/admin_fb.php');

/** 
 * This is admin controller for documents.
 * 
 * @package documents
 * @author Michael Kovalskiy
 * @version 2014
 * @access public
 */
class Documents extends Admin_fb
{
    protected $process_form_html_id = "documents";
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //

    /**
     * Validate and insert or update data.
     *
     * @param bool|string(16) $data_key
     * @param string $form_mode
     * @return \Documents
     */
	protected function _processInsert($data_key=FALSE,$form_mode='edit')
	{
		if($data_key) $this->load->vars($this->documents_model->getOneById($data_key));
	    
		parent::_processInsert($data_key,$form_mode);
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
}