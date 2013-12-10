<?php
/** 
 * This is controller for not found images (if image found CI not ran).
 * It is NOT REQUIRED. But it allows log full path of image that not found.
 * If remove this controller than error of not found image will be just: 404 Not Found "images" due to CI_Router log (line 348: show_404($segments[0]);).
 * 
 * @package exceptions  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Images extends CI_Controller  
{
    /**
     * Constructor for Images controller.
     *
     * @return \Images
     */
    public function __construct()
	{
		parent::__construct();
		
		show_404($this->input->server('REQUEST_URI'));
	}
}