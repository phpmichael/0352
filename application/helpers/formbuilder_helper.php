<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Build form with formbuilder.
 *
 * @param integer|string $form_id
 * @param char(16) $data_key
 * @param string|bool $form_mode (view|edit)
 */
function fb_form($form_id,$data_key=FALSE,$form_mode=FALSE)
{
	$formbuilder_model = load_model('formbuilder_model');
	if($form_mode) $formbuilder_model->setFormMode($form_mode);
	$formbuilder_model->buildForm($form_id,$data_key);
	
	if( $form_mode != 'view' ) 
	{
		$CI =& get_instance();
		$CI->load->view('inc/js-fb-screen-process');
	}
}

/**
 * Return answers' labels by stored values.
 * This needs for show selected answers.
 *
 * @param string $values
 * @param string $format
 * @param string $input_name
 * @param integer $form_id
 * @return mixed
 */
function fb_answers($values,$format="array",$input_name=FALSE,$form_id=FALSE)
{
	$formbuilder_model = load_model('formbuilder_model');
	return $formbuilder_model->getAnswersetLabelsByValues($values,$format=",",$input_name,$form_id);
}

/**
 * Return input's label by its name and form_id.
 *
 * @param string $name
 * @param integer|string $form_id
 * @return array
 */
function fb_input_label($name,$form_id)
{
	$formbuilder_model = load_model('formbuilder_model');
	return $formbuilder_model->getInputLabelByName($name,$form_id);
}