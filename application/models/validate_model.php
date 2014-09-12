<?php

/**
 * This is model for custom validation.
 *
 * @package validation
 * @author Michael Kovalskiy
 * @version 2014
 * @access public
 */
class Validate_model extends CI_Model
{
    private $c_table;

    /**
     * Check if field unique on edit record.
     *
     * @param string $field_value
     * @param string $param
     * @return bool
     */
    public function checkUniqueFieldOnEdit($field_value,$param)
    {
        if(!$field_value) return TRUE;//if no value means that is not required

        list($field_name, $current_id) = explode(',', $param);

        $id_column = ($this->db->field_exists('data_key',$this->c_table))?'data_key':'id';

        return !($this->db->get_where($this->c_table, array($field_name => $field_value,$id_column.' != '=>$current_id))->row_array());
    }

    /**
     * Set current table
     * @param string $table
     */
    public function setTable($table)
    {
        $this->c_table = $table;
    }
}