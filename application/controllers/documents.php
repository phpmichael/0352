<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for documents.
 * 
 * @package documents
 * @author Michael Kovalskiy
 * @version 2015
 * @access public
 */
class Documents extends Front
{
	//name of table
	protected $c_table = 'documents';

    /**
     * Init required models, helpers, language sections, pages' titles, css files etc.
     *
     * @return \Documents
     */
    public function __construct()
	{
		parent::__construct();
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front','documents'));
		
		// === Load Models === //
		$this->load->model('documents_model');
		$this->load->model('documents_categories_model');
        
        // === Page Titles === //
		$this->page_titles['index'] = language('documents_categories');
		$this->page_titles['search'] = language('documents');
		//default page title
		$this->_setDefaultPageTitle();
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //


	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// ============= ACTION METHODS ================ //

    /**
     * Download file from documents table.
     * @param $data_key
     * @return bool
     */
    public function Download($data_key)
	{
        if( $document = $this->documents_model->getOneById($data_key) )
        {
            $file_ext = strtolower(pathinfo($document['file_name'], PATHINFO_EXTENSION));
            $file_name = $document['name'] . '.' . $file_ext;

            if( in_array($file_ext, array('jpeg','jpg','png','gif')) )
                $path = 'b';//big image
            else
                $path = 'files';

            $file = './images/data/'.$path.'/documents/'.$document['file_name'];

            if( file_exists($file) )
            {
                $content = file_get_contents($file);

                $this->load->helper('download');
                force_download($file_name, $content);

                return TRUE;
            }
        }

        show_404($this->input->server('REQUEST_URI'));

        return FALSE;
	}

    /**
     * Show documents' categories list.
     *
     * @return void
     */
    public function Index()
    {
        $filter_data = $this->uri->uri_to_assoc($this->_getSegmentsOffset()+3);

        if(isset($filter_data['category']))
        {
            redirect($this->_getBaseURI()."/search/category/".$filter_data['category']);
        }

        $data['categories'] = $this->documents_categories_model->GetChildren(0,TRUE);

        $data['controller'] = $this->_getController();

        $data['tpl_page'] = "categories/list";

        // === Current Location === //
        $current_location_arr =
            array(
                $this->_getBaseURI()=>$this->_getPageTitle()
            );

        $data['current_location_arr'] = $current_location_arr;

        //generate additional page title
        $this->appendPageTitleForListPages($filter_data,$data);

        parent::_OnOutput($data);
    }

    /**
     * Show products list by filter.
     *
     * @return void
     */
    public function Search()
    {
        // === Filter Data === //
        $filter_data = $this->documents_model->getFilterData();

        if(isset($filter_data['empty_filter']))
        {
            $data['posts_list'] = false;
            $data['paginate'] = '';
        }
        else
        {
            $data = $this->documents_model->getAction("search", $filter_data);
        }

        $data = array_merge($data,$filter_data);

        $data['tpl_page'] = $this->_getController()."/list";

        // === Current Location === //
        $current_location_arr =
            array(
                $this->_getBaseURI()=>$this->_getPageTitle('index')
            );

        // === Categories Location === //
        $categories_location_arr = $this->documents_categories_model->GetLocation(@$filter_data['category'],$this->_getController());

        $current_location_arr = array_merge($current_location_arr,$categories_location_arr);

        $data['current_location_arr'] = $current_location_arr;

        //add search category info
        if(@$filter_data['category']) $data = array_merge($data,$this->documents_categories_model->getSearchCategoryData($filter_data['category']));

        //generate additional page title
        $this->appendPageTitleForListPages($filter_data,$data);

        parent::_OnOutput($data);
    }

}