<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Return random poll data.
 *
 * @param bool|int $poll_id
 * @return array
 */
function poll_data($poll_id=FALSE)
{
    $poll_model = load_model('poll_model');
    return $poll_model->getPollData($poll_id);
}

/**
 * Check if user voted current poll.
 *
 * @param array $poll_data
 * @return bool
 */
function poll_is_voted($poll_data)
{
    $CI =& get_instance();
    $customer_id = $CI->session->userdata('customer_id');
    return $CI->poll_model->isVoted($poll_data['poll']['id'],$customer_id);
}

/**
 * Return current poll results.
 *
 * @param array $poll_data
 * @return array
 */
function poll_results($poll_data)
{
    $poll_model = load_model('poll_model');
    return $poll_model->getPollResults($poll_data['poll']['id']);
}

/**
 * Return URL for poll form.
 *
 * @param array $poll_data
 * @return string
 */
function poll_form_open($poll_data)
{
    $CI =& get_instance();
    //return form_open($CI->_getBaseURL().'poll/submit/'.$poll_data['poll']['id'],array('id'=>'poll-form'));
    return "<form method='post' id='poll-form' action='".relative_url($CI->_getBaseURL().'poll/submit/'.$poll_data['poll']['id'])."'>";
}

/**
 * Return URL for load poll results.
 *
 * @param array $poll_data
 * @return string
 */
function poll_results_url($poll_data)
{
    $CI =& get_instance();
    return relative_url($CI->_getBaseURL().'poll/results/'.$poll_data['poll']['id']);
}

/**
 * Return poll title
 *
 * @param array $poll_data
 * @return string
 */
function poll_title($poll_data)
{
    return htmlspecialchars($poll_data['poll']['title']);
}

/**
 * Return poll available answers.
 *
 * @param array $poll_data
 * @return array
 */
function poll_answers($poll_data)
{
    return $poll_data['answers'];
}

/**
 * Return answer title.
 *
 * @param array $answer
 * @return string
 */
function poll_answer($answer)
{
    return htmlspecialchars($answer['answer']);
}

/**
 * Return radio button and answer title.
 *
 * @param array $answer
 * @return string
 */
function poll_answer_option($answer)
{
    return form_radio('answer',$answer['id'],FALSE,"id='answer_{$answer['id']}'").' <label for="answer_'.$answer['id'].'">'.htmlspecialchars($answer['answer']).'</label>';
}

/**
 * Return styles for bar that show amount of votes for current answer.
 *
 * @param array $result
 * @return string
 */
function poll_result_bar($result)
{
    return 'style="width:'.$result['width'].'%;background:'.$result['color'].'"';
}