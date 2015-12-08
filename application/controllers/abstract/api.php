<?php
require_once(APPPATH.'libraries/REST_Controller.php');

/**
 * This is basic controller for api controllers.
 *
 * @package api
 * @author Michael Kovalskiy
 * @version 2014
 * @access public
 */
abstract class API extends REST_Controller
{
    //start url section
    protected $segmentsOffset = 0;
    protected $interface_lang;
    protected $panel = 'admin';
    //this is for models that use formbuilder
    protected $process_form_html_id;
    protected $model_name;
    protected $model;
    protected $messages = array(
        'item_not_found' => 'Item not found',
        'empty_data' => 'No data posted',
        'item_saved' => 'Item saved',
        'no_item_id' => 'No item\'s ID',
        'item_updated' => 'Item updated',
        'item_deleted' => 'Item deleted',
        'enter_email_and_password' => 'Enter email and password',
        'access_allowed' => 'Access allowed',
        'access_denied' => 'Access denied',
    );
    protected $c_table;
    protected $list_fields = array();
    protected $user = false;

    /**
     * Init models and set language
     */
    public function __construct()
    {
        parent::__construct();

        // === Load Models === //
        $this->load->model($this->model_name);
        $this->model = $this->{$this->model_name};
        if($this->process_form_html_id) $this->load->model('formbuilder_model');

        //set language based on URL
        $this->lang_model->setApplicationLanguage($this);

        // === Init Language Section === //
        $this->lang_model->init(array('label','admin'));
    }

    /**
     * Get one record by ID or get list of records by search criterias
     */
    public function index_get()
    {
        if($id = $this->get('id'))
        {
            $this->getItem($id);
        }
        else
        {
            $this->getItems();
        }
    }

    /**
     * Add new record
     */
    public function index_post()
    {
        $data = $_POST = $this->post();

        //TODO: set logged customer id, next line doesn't help :(
        //$data['customer_id'] = $this->user['id'];

        if(empty($data))
        {
            $this->response(array('errors' => array($this->messages['empty_data'])), 200);
        }
        elseif($id = $this->model->storeForm($data,$this->process_form_html_id))
        {
            $this->response(array('success' => array('message' => $this->messages['item_saved'], 'id' => $id)), 200);
        }
        else
        {
            $this->outputValidationErrors();
        }
    }

    /**
     * Update existing record
     */
    public function index_put()
    {
        if(!($id = $this->get('id')))
        {
            $this->response(array('errors' => array($this->messages['no_item_id'])), 404);
        }

        $data = $_POST = $this->put();

        if(empty($data))
        {
            $this->response(array('errors' => array('No data posted')), 200);
        }
        elseif($this->model->storeForm($data,$this->process_form_html_id,$id))
        {
            $this->response(array('success' => array('message' => $this->messages['item_updated'])), 200);
        }
        else
        {
            $this->outputValidationErrors();
        }
    }

    /**
     * Delete record
     */
    public function index_delete()
    {
        if($id = $this->get('id'))
        {
            if($item = $this->model->existsId($id))
            {
                $this->model->deleteId($id);

                $this->response(array('success' => array('message' => $this->messages['item_deleted'])), 200);
            }
            else
            {
                $this->response(array('errors' => array('Not found')), 404);
            }
        }
    }

    /* Auth functions */

    /**
     * Check auth credentials
     */
    public function auth_post()
    {
        $email = $this->post('email');
        $password = $this->post('password');

        if(empty($email) || empty($password))
        {
            $this->response(array('errors' => array($this->messages['enter_email_and_password'])), 200);
        }
        elseif($this->hasAccess($email,$password))
        {
            $this->response(array('success' => array('message' => $this->messages['access_allowed'])), 200);
        }
        else
        {
            $this->response(array('errors' => array($this->messages['access_denied'])), 200);
        }
    }

    /**
     * Override default auth check in REST_Controller
     * @param string $email
     * @param null|string $password
     * @return bool
     */
    protected function _perform_library_auth($email, $password)
    {
        return $this->hasAccess($email, $password);
    }

    /**
     * Check if correct $email and $password combination, and if user has access to API section
     * @param string $email
     * @param string $password
     * @return bool
     */
    protected function hasAccess($email, $password)
    {
        //if($this->request->method === 'get') return TRUE;

        $this->user = $this->customers_model->checkLogin($email,$password);
        if(!$this->user) return FALSE;

        $this->load->model('groups_model');
        $section = str_replace('_model','',$this->model_name);
        return $this->groups_model->hasApiAccess($this->user,$this->request->method,$section,$this->panel);
    }


    // === Additional methods like in  Base controller === //

    /**
     * Returns segment offset (0 or 1).
     *
     * @return integer
     */
    public function _getSegmentsOffset()
    {
        return $this->segmentsOffset;
    }

    /**
     * Return just current lang info
     * @return bool
     */
    public function _isJustCurrentLang()
    {
        return TRUE;
    }

    /**
     * Returns API folder name.
     *
     * @return string
     */
    public function _getFolder()
    {
        return 'api/';
    }

    /**
     * Set interface language.
     *
     * @param string $lang
     */
    public function setInterfaceLang($lang)
    {
        $this->interface_lang = $lang;
    }

    /**
     * Return interface language.
     *
     * @param bool $getDefault
     * @return string
     */
    public function _getInterfaceLang($getDefault=FALSE)
    {
        $lang = $this->interface_lang;
        if(!$lang && $getDefault)
        {
            return strtolower($this->lang_model->getDefaultLangCode());
        }
        return $lang;
    }

    /**
     * Increment segment offset
     */
    public function incSegmentsOffset()
    {
        $this->segmentsOffset++;
    }

    /**
     * Validate if unique value while edit record
     * @param $field_value
     * @param $param
     * @return bool
     */
    public function _unique_field_for_edit($field_value,$param)
    {
        $this->load->model('validate_model');
        $this->validate_model->setTable($this->c_table);
        return $this->validate_model->checkUniqueFieldOnEdit($field_value,$param);
    }


    // === Stuff for easy extend === //
    /**
     * Return one item
     * @param integer|string $id
     */
    protected function getItem($id)
    {
        if($item = $this->model->getOneById($id))
        {
            $this->response($item, 200);
        }
        else
        {
            $this->response(array('error' => array($this->messages['item_not_found'])), 404);
        }
    }

    /**
     * Return items list
     */
    protected function getItems()
    {
        if($this->hasPagination())
        {
            $filter_data = $this->model->getFilterData();
            $data = $this->model->get('',$filter_data);
        }
        else
        {
            $data['posts_list'] = $this->model->getAll($this->list_fields);
        }

        $this->response($data, 200);
    }

    /**
     * Show validation errors
     */
    protected function outputValidationErrors()
    {
        $errors = explode("\n",validation_errors(' ',' '));
        array_pop($errors);//remove last empty element
        $this->response(array('errors' => $errors), 200);
    }

    /**
     * Check if need pagination
     * @return bool
     */
    private function hasPagination()
    {
        $uriArr = $this->uri->uri_to_assoc($this->_getSegmentsOffset()+3);
        return isset($uriArr['per_page']);
    }
}