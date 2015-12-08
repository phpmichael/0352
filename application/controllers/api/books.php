<?php
require_once(APPPATH.'controllers/abstract/api.php');

/**
 * API Books controller
 */
class Books extends API
{
    protected $process_form_html_id = "books";
    protected $model_name = "books_model";
    protected $c_table = "books";
}