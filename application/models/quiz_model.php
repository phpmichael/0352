<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * Quiz model.
 * Tables:
 * quiz_list - list of quizes (name, description etc)
 * quiz_questions - questions for each quiz
 * quiz_answers - answers for each question
 * quiz_store - store for customer's answers
 * quiz_archive - store for customer's finished quizes (just for review)
 * quiz_progress - store last question of customer's active quiz
 * quiz_questions_copies - reference for origin question
 *
 * @package quiz  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Quiz_model extends Base_model
{
	//name of main table
	protected $c_table = 'quiz_list';

    //dir for upload images
    protected $upload_path = './images/data/b/quiz/';
    //allowed file types
    protected $allowed_types = 'jpg|png';

    private $connected_scores_type = '+1'; //"+1" or "+1/count"
    private $digits3_scores_type = '+1'; //"+1" or "1 or 0"

	/**
	 * Returns quizes array by $params.
	 * 
	 * @param array $params
	 * @param array $order
	 * @return array
	 */
	public function getQuizRecords(array $params=array(), $order=array('orderby'=>'sort','direction'=>'asc'))
	{
		$this->db->order_by($order['orderby'], $order['direction']);
	    return $this->db->get_where('quiz_list',$params)->result_array();
	}
	
	/**
	 * Returns quizes array by $params in format id=>name.
	 * 
	 * @param array $params
	 * @return array
	 */
	public function getQuizList($params)
	{
	    $records = $this->getQuizRecords($params);
	    $list = array();
	    foreach ($records as $record)
	    {
	        $list[$record['id']] = $record['name'];
	    }
	    
	    return $list;
	}
	
	/**
	 * Returns array of questions for quiz.
	 * 
	 * @param integer $quiz_id
	 * @return array
	 */
	public function getQuestions($quiz_id)
	{
        $this->db->order_by('sort');
		return $this->db->get_where('quiz_questions',array('quiz_id'=>$quiz_id))->result_array();
	}
	
	/**
	 * Returns array of answers for question.
	 * 
	 * @param integer $question_id
	 * @return array
	 */
	public function getAnswers($question_id)
	{
		$this->db->order_by('id');
		return $this->db->get_where('quiz_answers',array('question_id'=>$question_id, 'connect_answer' => 0))->result_array();
	}

    /**
     * Return array of answers connected to other answers
     * @param integer $question_id
     * @return array
     */
    public function getConnectedAnswers($question_id)
    {
        $this->db->order_by('id');
        return $this->db->get_where('quiz_answers',array('question_id'=>$question_id, 'connect_answer !=' => 0))->result_array();
    }

    /**
     * Return array of answers available for connect to current $answer_id or new answer
     * @param integer $question_id
     * @param bool|integer $answer_id
     * @return array
     */
    public function getAnswersForConnect($question_id, $answer_id=false)
    {
        //get all not connected yet
        $answers = $this->getAnswers($question_id);
        foreach ($answers as $answer)
        {
            //No ability connect if there is correct answer(s)!
            if($answer['correct']) return array();
        }

        $dropdown_answers = multi2singleArray('id', 'answer', $answers);
        //No ability connect answer to itself
        if($answer_id) unset($dropdown_answers[$answer_id]);

        $connected_answers = $this->getConnectedAnswers($question_id);
        if(!empty($connected_answers))
        {
            foreach ($connected_answers as $connected_answer)
            {
                if($connected_answer['id'] !== $answer_id)
                {
                    //No ability connect the same answer to few other
                    unset($dropdown_answers[$connected_answer['connect_answer']]);
                }
            }
        }

        //first option for ability disconnect
        return array(0 => '-') + $dropdown_answers;
    }
	
	/**
	 * Returns array of correct answers for question.
	 * 
	 * @param integer $question_id
	 * @return array
	 */
	public function getCorrectAnswers($question_id)
	{
		return $this->db->get_where('quiz_answers',array('question_id'=>$question_id,'correct'=>1))->result_array();
	}
	
	/**
	 * Returns IDs of correct answers for question.
	 * 
	 * @param integer $question_id
	 * @return array
	 */
	private function getCorrectAnswersIDs($question_id)
	{
		$answersIDs = array();
		$answers = $this->getCorrectAnswers($question_id);
		foreach ($answers as $answer)
		{
			$answersIDs[] = $answer['id'];
		}
		
		return $answersIDs;
	}
	
	/**
	 * Returns question record by ID.
	 * 
	 * @param integer $id
	 * @return array
	 */
	public function getQuestionById($id)
	{
		$this->c_table = 'quiz_questions';
		
		return $this->getOneById($id);
	}
	
	/**
	 * Returns answer record by ID.
	 * 
	 * @param integer $id
	 * @return array
	 */
	public function getAnswerById($id)
	{
		$this->c_table = 'quiz_answers';
		
		return $this->getOneById($id);
	}
	
	/**
	 * Insert or update question. Depends if ID field presents in array.
	 * 
	 * @param array $post
	 * @return integer
	 */
	public function insertOrUpdateQuestion($post)
	{
		$this->c_table = 'quiz_questions';
		
		$post['code'] = preg_replace("/((\r)?\n)+/","\n",$post['code']);
		
		return parent::insertOrUpdate($post);
	}
	
	/**
	 * Insert or update data. Depends if ID field presents in array.
	 * 
	 * @param array $post
	 * @return integer
	 */
	public function insertOrUpdateAnswer($post)
	{
		$this->c_table = 'quiz_answers';

		if($image = $this->uploadImage('image'))
        {
            $post['image'] = $image;
        }
		
		return parent::insertOrUpdate($post);
	}

    /**
     * Upload image and return generated name.
     * @param string $image_field
     * @return bool|string
     */
    private function uploadImage($image_field)
    {
        if (@empty($_FILES[$image_field]['name'])) return FALSE;

        $config = array();
        $config['upload_path'] = $this->upload_path;
        $config['allowed_types'] = $this->allowed_types;
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = ((@$this->CI->settings_model['upload_max_filesize']) ? $this->CI->settings_model['upload_max_filesize'] : 2048);

        //  === LOAD UPLOAD CLASS === //
        $this->CI->load->library('upload', $config);

        if (!$this->CI->upload->do_upload($image_field)) {
            die($this->CI->upload->display_errors());
        }

        // === DATA === //
        $data['upload_data'] = $this->CI->upload->data();

        return $data['upload_data']['file_name'];
    }
	
	
	/**
	 * Delete quizes by IDs.
	 * 
	 * @param array $delArr (array of quizes' IDs)
	 * @return void
	 */
	public function deleteSelectedQuiz($delArr)
	{
		if( !empty($delArr) )
		{
			foreach ($delArr as $id=>$selected)
			{
				//delete quiz questions and answers
			    $questions = $this->db->get_where('quiz_questions', array('quiz_id' => $id))->result_array();
				$delQuestionsArr = array();
				foreach ($questions as $question)
				{
					$delQuestionsArr[$question['id']] = 1;
				}
				$this->deleteSelectedQuestions($delQuestionsArr);
				
				//delete archives
				$this->db->delete('quiz_archive', array('quiz_id' => $id));
				
				//delete quiz
				$this->db->delete('quiz_list', array('id' => $id));
			}
		}
	}
	
	/**
	 * Delete questions by IDs.
	 * 
	 * @param array $delArr
	 * @return void
	 */
	public function deleteSelectedQuestions($delArr)
	{
		if( !empty($delArr) )
		{
			foreach ($delArr as $id=>$selected)
			{
				$this->db->delete('quiz_answers', array('question_id' => $id));
				//TODO: delete answers' images
				
				$this->db->delete('quiz_questions', array('id' => $id));

				$this->deleteQuestionCopyReference($id);
			}
		}
	}
	
	/**
	 * Delete answers by IDs.
	 * 
	 * @param array $delArr
	 * @return void
	 */
	public function deleteSelectedAnswers($delArr)
	{
		if( !empty($delArr) )
		{
			foreach ($delArr as $id=>$selected)
			{
				$this->db->delete('quiz_answers', array('id' => $id));
			}
		}
	}
	
	/**
	 * After user answer on question this method generate new question for him.
	 * It takes one of not answered questions in random order.
	 * If user refresh page it returns the same question.
	 * 
	 * @param integer $quiz_id
	 * @param integer $customer_id
	 * @return array
	 */
	public function getNextQuestion($quiz_id,$customer_id)
	{
		//set quiz
		$record['quiz'] = $this->getOneById($quiz_id);
		
		//try if there is currently active question
		if( $current_question = $this->getCurrentQuizQuestion($customer_id,$quiz_id) )
		{
		    $record['question'] =  $this->db->get_where('quiz_questions',array('id'=>$current_question['question_id']))->row_array();
		    
		    //how much time left for answer
		    $record['question']['time'] -= (time() - $current_question['start_time']);
		}
		else 
		{
		    //get what question already answered
    		$answered_questions = $this->getCustomerAnsweredQuestionsIDs($quiz_id,$customer_id);
    		//get random not answered question from quiz
    		//$this->db->order_by('RAND()');
    		$this->db->order_by('sort');
    		if( !empty($answered_questions) ) $this->db->where_not_in('id',$answered_questions);
    		$record['question'] = $this->db->get_where('quiz_questions',array('quiz_id'=>$quiz_id))->row_array();
    		
    		//mark question as started (run timer for it)
		    $this->questionStarted($customer_id,$quiz_id,$record['question']['id']);
		}
		
		//get answers for question
		$record['answers'] = $this->getAnswers($record['question']['id']);
		//get correct answers for question
		$record['correct_answers'] = $this->getCorrectAnswers($record['question']['id']);
		//if one answer - show input, few correct answers - then checkboxes, if just one correct - radiobox
        $record['type'] = $this->getQuestionType($record['question']['id'], $record['answers'], $record['correct_answers']);

        if($record['type'] == 'multi-radio')
        {
            $record['connected_answers'] = $this->getConnectedAnswers($record['question']['id']);
        }

        //TODO: if not multi-radio - randomize order of answers
		//dump($record);exit;
        //shuffle($record['answers']);
		return $record;
	}

    /**
     * Return question's type by count answers and correct answers
     * @param int $question_id
     * @param array $answers
     * @param array $correct_answers
     * @return string
     */
	public function getQuestionType($question_id, array $answers=array(), array $correct_answers=array())
    {
        if(empty($answers)) $answers = $this->getAnswers($question_id);
        if(empty($correct_answers)) $correct_answers = $this->getCorrectAnswers($question_id);

        if(count($answers)==1)
        {
            return 'input';
        }
        elseif(count($correct_answers)>1)
        {
            if(count($correct_answers)==3 && count($answers)==7)
            {
                return 'digits3';
            }
            else
            {
                return 'checkbox';
            }
        }
        elseif(count($correct_answers)==1)
        {
            return 'radio';
        }
        elseif(count($correct_answers)==0)
        {
            return 'multi-radio';
        }
    }
	
	/**
	 * Returns array of already answered questions.
	 * 
	 * @param integer $quiz_id
	 * @param integer $customer_id
	 * @return array
	 */
	private function getCustomerAnsweredQuestions($quiz_id,$customer_id)
	{
		return $this->db->get_where('quiz_store',array('quiz_id'=>$quiz_id,'customer_id'=>$customer_id))->result_array();
	}
	
	/**
	 * Returns array of already answered questions' IDs.
	 * 
	 * @param integer $quiz_id
	 * @param integer $customer_id
	 * @return array
	 */
	private function getCustomerAnsweredQuestionsIDs($quiz_id,$customer_id)
	{
		$answered_questions = array();
		$questions = $this->getCustomerAnsweredQuestions($quiz_id,$customer_id);
		foreach ($questions as $question)
		{
			$answered_questions[] = $question['question_id'];
		}
		
		return $answered_questions;
	}
	
	/**
	 * Returns count of already answered questions.
	 * 
	 * @param integer $quiz_id
	 * @param integer $customer_id
	 * @return integer
	 */
	public function getAmountCustomerAnsweredQuestions($quiz_id,$customer_id)
	{
		$this->db->group_by('question_id');
		return count($this->db->select('question_id')->get_where('quiz_store',array('quiz_id'=>$quiz_id,'customer_id'=>$customer_id))->result_array());
	}
	
	/**
	 * Returns required amount answers to finish quiz.
	 * 
	 * @param integer $quiz_id
	 * @return integer
	 */
	public function getRequiredAmountQuestions($quiz_id)
	{
		$quiz = parent::getOneById($quiz_id);
		return $quiz['questions_count'];
	}
	
	/**
	 * Check if user already answered on this question.
	 * 
	 * @param integer $quiz_id
	 * @param integer $customer_id
	 * @param integer $question_id
	 * @return array
	 */
	public function questionAnswered($quiz_id,$customer_id,$question_id)
	{
	    return $this->db->get_where('quiz_store',array('quiz_id'=>$quiz_id,'customer_id'=>$customer_id,'question_id'=>$question_id))->row_array();
	}
	
	/**
	 * Save user's answer (selected checkboxes/radio).
	 * 
	 * @param integer $quiz_id
	 * @param integer $customer_id
	 * @param integer $question_id
	 * @param integer $answer_id
	 * @param integer $connect_answer
	 * @return void
	 */
	public function storeAnswer($quiz_id,$customer_id,$question_id,$answer_id,$connect_answer=0)
	{
		//mark question as answered
		$this->questionEnded($customer_id,$quiz_id,$question_id);
	    
	    $this->c_table = 'quiz_store';
		
		parent::insert(array('quiz_id'=>$quiz_id,'customer_id'=>$customer_id,'question_id'=>$question_id,'answer_id'=>$answer_id,'connect_answer'=>$connect_answer));
	}

    /**
     * Save user's answer (filled input).
     *
     * @param integer $quiz_id
     * @param integer $customer_id
     * @param integer $question_id
     * @param $custom_answer
     * @return void
     */
	public function storeCustomAnswer($quiz_id,$customer_id,$question_id,$custom_answer)
	{
		//mark question as answered
		$this->questionEnded($customer_id,$quiz_id,$question_id);
	    
	    $this->c_table = 'quiz_store';
		
		parent::Insert(array('quiz_id'=>$quiz_id,'customer_id'=>$customer_id,'question_id'=>$question_id,'custom_answer'=>$custom_answer));
	}
	
	/**
	 * If user skip question.
	 * 
	 * @param integer $quiz_id
	 * @param integer $customer_id
	 * @param integer $question_id
	 * @return void
	 */
	public function storeNoAnswer($quiz_id,$customer_id,$question_id)
	{
	    $this->storeAnswer($quiz_id,$customer_id,$question_id,0);
	}
	
	/**
	 * Check if user answered in time.
	 * 
	 * @param integer $quiz_id
	 * @param integer $customer_id
	 * @param integer $question_id
	 * @return bool
	 */
	public function ifAnsweredInTime($quiz_id,$customer_id,$question_id)
	{
	    $quiz = $this->getOneById($quiz_id);
	    if(!$quiz['use_timer']){//if quiz timer disabled - always in time
	        return true;
        }

	    $chance = 5;
	    $current_question = $this->getCurrentQuizQuestion($customer_id,$quiz_id);
	    $question = $this->getQuestionById($question_id);
	    if( time() - $current_question['start_time'] > $question['time'] + $chance )
	    {
	        return FALSE;
	    }
	    else return TRUE;
	}
	
	/**
	 * Returns how many correct answers user gave.
	 * 
	 * @param integer $quiz_id
	 * @param integer $customer_id
	 * @return integer
	 */
	public function getScores($quiz_id,$customer_id)
	{
		$result = $this->checkIfCorrectAnswers($quiz_id,$customer_id);
		return $result['scores'];
	}
	
	/**
	 * Check if user answered enough questions to finish quiz.
	 * 
	 * @param integer $quiz_id
	 * @param integer $customer_id
	 * @return integer
	 */
	public function isQuizFinished($quiz_id,$customer_id)
	{
		$answered = $this->getAmountCustomerAnsweredQuestions($quiz_id,$customer_id);
		$total_questions = $this->getRequiredAmountQuestions($quiz_id);
		return ($answered==$total_questions);
	}
	
	/**
	 * Returns array of started, but not finished quizes.
	 * 
	 * @param integer $customer_id
	 * @return array
	 */
	public function getCustomerNotFinishedQuizList($customer_id)
	{
		$sql = "select quiz_list.* from quiz_progress join quiz_list on quiz_progress.quiz_id=quiz_list.id where quiz_progress.end_time=0 and quiz_progress.customer_id=? group by quiz_id";
		$records = $this->db->query($sql,array($customer_id))->result_array();
		
		$results = array();
		foreach ($records as $key=>$record)
		{
			$results[$key]['quiz'] = $record;
		    $results[$key]['answered'] = $this->getAmountCustomerAnsweredQuestions($record['id'],$customer_id);
		}
		
		return $results;
	}
	
	/**
	 * Returns array of finished quizes.
	 * 
	 * @param integer $customer_id
	 * @return array
	 */
	public function getCustomerQuizArchives($customer_id)
	{
		$sql = "select * from quiz_archive where customer_id=? order by finished desc";
		$records = $this->db->query($sql,array($customer_id))->result_array();
		
		foreach ($records as &$record)
		{
		    $record = $this->unserializeArchive($record);
		}
		
		return $records;
	}
	
	/**
	 * Unserialize finished quiz data.
	 * 
	 * @param array $record
	 * @return array
	 */
	private function unserializeArchive($record)
	{
	    $data = unserialize($record['data']);
	    unset($record['data']);
	    $record = array_merge($record,$data);
	    
	    return $record;
	}
	
	/**
	 * Calculate correct answered questions.
	 * 
	 * @param integer $quiz_id
	 * @param integer $customer_id
	 * @return array
	 */
	public function checkIfCorrectAnswers($quiz_id,$customer_id)
	{
		$result['scores'] = 0;
		$result['correctArr'] = array();
		$result['answers'] = array();
		$result['correct_answers'] = array();
		$result['customer_answers'] = array();
		
		$answered_questions = $this->getCustomerAnsweredQuestions($quiz_id,$customer_id);

		if(empty($answered_questions)) return $result;

		$customer_question_answers = array();
		$has_connect_answers = array();

		foreach ($answered_questions as $aq)
		{
			if($aq['custom_answer']) 
			{
				$customer_question_answers[$aq['question_id']] = $aq['custom_answer'];
			}
			else 
			{
				if($aq['connect_answer'])
				{
					$has_connect_answers[$aq['question_id']] = TRUE;
					$customer_question_answers[$aq['question_id']][$aq['answer_id']] = $aq['connect_answer'];
				}
				else $customer_question_answers[$aq['question_id']][] = $aq['answer_id'];
			}
		}

		foreach ($customer_question_answers as $question_id=>$cqa)
		{
		    $answers = $this->getAnswers($question_id);

			$connected_answers = array();
			if(is_array($cqa))
			{
				if(isset($has_connect_answers[$question_id]))//multi-radio
				{
					$correct_question_answers = array();

					$connected_answers = $this->getConnectedAnswers($question_id);
					$count_connected = count($connected_answers);

					$scores = 0;
                    $is_correct = FALSE;
					foreach ($connected_answers as $connected_answer)
					{
						$correct_question_answers[$connected_answer['id']] = $connected_answer['connect_answer'];

						if($cqa[$connected_answer['id']] == $connected_answer['connect_answer'])
						{
						    if($this->connected_scores_type === '+1/count')
                            {
                                $scores += 1/$count_connected;
                                $is_correct = ($scores > 0.9);
                            }
                            else//+1
                            {
                                $scores += 1;
                                $is_correct = ($scores === $count_connected);
                            }
						}
					}

					$result['correctArr'][$question_id] = ($is_correct) ? TRUE : FALSE;
                    $result['scores'] += $scores;
					
					ksort($cqa);
					ksort($correct_question_answers);
				}
				else//checkbox/radio/digits3
				{
					$correct_question_answers = $this->getCorrectAnswersIDs($question_id);

					sort($correct_question_answers);
					sort($cqa);

                    $is_digits3 = (count($answers) === 7 && count($correct_question_answers) === 3);

                    if($is_digits3 && $this->digits3_scores_type === '+1')
                    {
                        for($i = 0; $i < 3; $i++)
                        {
                            if($correct_question_answers[$i] === $cqa[$i])
                            {
                                $result['scores']++;
                            }

                            $result['correctArr'][$question_id] = ($correct_question_answers === $cqa);
                        }
                    }
                    else//1 or 0
                    {
                        if( $correct_question_answers != $cqa )
                        {
                            $result['correctArr'][$question_id] = FALSE;
                        }
                        else
                        {
                            $result['correctArr'][$question_id] = TRUE;
                            $result['scores']++;
                        }
                    }
				}
			}
			else //input
			{
				$correct_question_answers = array();

				if( $result['correctArr'][$question_id] = $this->checkIfCorrectCustomAnswer($question_id,$cqa) )
				{
					$result['scores']++;
				}
			}
			
			$result['answers'][$question_id] = $answers;
			$result['correct_answers'][$question_id] = @$correct_question_answers;
			$result['customer_answers'][$question_id] = $cqa;
			$result['connected_answers'][$question_id] = $connected_answers;
		}
		
		return $result;
	}
	
	/**
	 * Check if custom (filled input) answer is correct.
	 * 
	 * @param integer $question_id
	 * @param string $custom_answer
	 * @return bool
	 */
	private function checkIfCorrectCustomAnswer($question_id,$custom_answer)
	{
		$row = $this->db->get_where('quiz_answers',array('question_id'=>$question_id))->row_array();
		return ($row['answer']==$custom_answer);
	}
	
	/**
	 * Returns array of correct user's answers.
	 * 
	 * @param integer $quiz_id
	 * @param integer $customer_id
	 * @return array
	 */
	public function getCustomerCorrectAnswers($quiz_id,$customer_id)
	{
		$result = $this->checkIfCorrectAnswers($quiz_id,$customer_id);
		return $result['correctArr'];
	}
	
	/**
	 * Archive quiz.
	 * 
	 * @param integer $customer_id
	 * @param integer $quiz_id
	 * @param integer $scores
	 * @param array $data
	 * @return integer
	 */
	public function addToArchive($customer_id,$quiz_id,$scores,array $data)
	{
	    $started = $this->getFirstQuestionStartTime($customer_id,$quiz_id);
	    $finished = time();
	    
	    //remove quiz data from store
	    $this->db->delete('quiz_store',array('customer_id'=>$customer_id,'quiz_id'=>$quiz_id));
	    
	    //remove quiz data from progress
	    $this->db->delete('quiz_progress',array('customer_id'=>$customer_id,'quiz_id'=>$quiz_id));
	    
	    $post['customer_id'] = $customer_id;
	    $post['quiz_id'] = $quiz_id;
	    $post['scores'] = $scores;
	    $post['questions_count'] = $data['quiz']['questions_count'];
	    $post['correct_count'] = $data['quiz']['correct_count'];
	    $post['started'] = $started;
	    $post['finished'] = $finished;
	    $post['data'] = serialize($data);
	    
	    $this->c_table = 'quiz_archive';
	    
	    return parent::Insert($post);
	}
	
	/**
	 * Unserialize quiz archive.
	 * 
	 * @param integer $customer_id
	 * @param integer $archive_id
	 * @return array
	 */
	public function getCustomerQuizArchive($customer_id,$archive_id)
	{
	    $record = $this->db->get_where('quiz_archive',array('customer_id'=>$customer_id,'id'=>$archive_id))->row_array();
	    if(!$record) return FALSE;
	    return $this->unserializeArchive($record);
	}
	
	/**
	 * Returns amount of quiz questions.
	 * 
	 * @param integer $quiz_id
	 * @return integer
	 */
	public function getTotalQuizQuestions($quiz_id)
	{
	    $record = $this->db->select("COUNT(*) AS amount")->get_where('quiz_questions',array('quiz_id'=>$quiz_id))->row_array();
	    return $record['amount'];
	}
	
	/**
	 * Add question in progress table (start timestamp). 
	 * 
	 * @param integer $customer_id
	 * @param integer $quiz_id
	 * @param integer $question_id
	 * @return integer
	 */
	private function questionStarted($customer_id,$quiz_id,$question_id)
	{
	    $post['customer_id'] = $customer_id;
	    $post['quiz_id'] = $quiz_id;
	    $post['question_id'] = $question_id;
	    $post['start_time'] = time();
	    
	    $this->c_table = 'quiz_progress';
	    
	    return parent::Insert($post);
	}
	
	/**
	 * Mark question answered (end timestamp). 
	 * 
	 * @param integer $customer_id
	 * @param integer $quiz_id
	 * @param integer $question_id
	 * @return void
	 */
	private function questionEnded($customer_id,$quiz_id,$question_id)
	{
	    $post['end_time'] = time();
	    
	    $this->c_table = 'quiz_progress';
	    
	    $this->db->update($this->c_table, $post, array('customer_id' => $customer_id, 'quiz_id' => $quiz_id, 'question_id' => $question_id ) );
	}
	
	/**
	 * Get current question (user need to answer on it in current moment). 
	 * 
	 * @param integer $customer_id
	 * @param integer $quiz_id
	 * @return array
	 */
	private function getCurrentQuizQuestion($customer_id,$quiz_id)
	{
	    return $this->db->get_where('quiz_progress',array('customer_id'=>$customer_id,'quiz_id'=>$quiz_id,'end_time'=>0))->row_array();
	}
	
	
	/**
	 * Returns array of quiz answered questions. 
	 * 
	 * @param integer $quiz_id
	 * @param integer $customer_id
	 * @return array
	 */
	public function getFinishedQuizQuestions($quiz_id,$customer_id)
	{
	    $this->db->select('quiz_questions.*,quiz_progress.start_time,quiz_progress.end_time');
	    $this->db->join('quiz_progress',"quiz_progress.question_id=quiz_questions.id");
	    $this->db->order_by('quiz_progress.start_time');
	    return $this->db->get_where('quiz_questions',array('quiz_questions.quiz_id'=>$quiz_id,'quiz_progress.customer_id'=>$customer_id))->result_array();
	}
	
	/**
	 * Get time from quiz_progress when first question was started. 
	 * 
	 * @param integer $customer_id
	 * @param integer $quiz_id
	 * @return integer
	 */
	private function getFirstQuestionStartTime($customer_id,$quiz_id)
	{
	    $this->db->order_by('start_time');
	    $record =  $this->db->get_where('quiz_progress',array('customer_id'=>$customer_id,'quiz_id'=>$quiz_id))->row_array();
	    return $record['start_time'];
	}
	
	/**
	 * Get top rated results.
	 * 
	 * @param integer $quiz_id
	 * @return array
	 */
	public function getTopRatedList($quiz_id)
	{
	    $sql = "select quiz_archive.*, quiz_archive.finished-quiz_archive.started as `time`, customers.name from quiz_archive 
                join customers on customers.id=quiz_archive.customer_id
                where quiz_archive.quiz_id=?
                order by scores desc, `time` asc, finished desc
                limit 20";
	    
	    return $this->db->query($sql,array($quiz_id))->result_array();
	}

    /**
     * Copy question to another quiz
     * @param integer $question_id
     * @param integer $quiz_id
     */
	public function copyQuestion($question_id,$quiz_id)
    {
        $question = $this->getQuestionById($question_id);
        $answers = $this->getAnswers($question_id);
        $connected_answers = $this->getConnectedAnswers($question_id);

        //copy question record
        unset($question['id']);
        $question['quiz_id'] = $quiz_id;
        $question_copy_id = $this->insertOrUpdateQuestion($question);

        //copy answers records
        $answers_copy = array();
        foreach ($answers as $answer)
        {
            $answer_id = $answer['id'];
            unset($answer['id']);
            $answer['question_id'] = $question_copy_id;
            $copy_answer_id = $this->insertOrUpdateAnswer($answer);
            $answers_copy[$answer_id] = $copy_answer_id;
        }

        //copy connected answers records
        foreach ($connected_answers as $connected_answer)
        {
            unset($connected_answer['id']);
            $connected_answer['question_id'] = $question_copy_id;
            $connected_answer['connect_answer'] = (int)$answers_copy[$connected_answer['connect_answer']];
            $this->insertOrUpdateAnswer($connected_answer);
        }

        $this->saveQuestionCopyReference($question_id, $question_copy_id);
    }

    /**
     * Save original question ID on copy
     * @param int $orig_id
     * @param int $copy_id
     */
    private function saveQuestionCopyReference($orig_id, $copy_id)
    {
        $this->db->insert('quiz_questions_copies', array('orig_id'=>$orig_id,'copy_id'=>$copy_id));
    }

    /**
     * Delete copy reference when question deleted
     * @param int $question_id
     */
    private function deleteQuestionCopyReference($question_id)
    {
        $this->db->delete('quiz_questions_copies', array('copy_id' => $question_id));
        $this->db->delete('quiz_questions_copies', array('orig_id' => $question_id));
    }

    /**
     * Return original question's quiz
     * @param int $question_id
     * @return array
     */
    public function getQuestionCopyOrigQuiz($question_id)
    {
        $sql = 'select l.id, l.name from quiz_questions_copies c 
                join quiz_questions q on q.id=c.orig_id
                join quiz_list l on l.id=q.quiz_id
                where copy_id=?';

        return $this->db->query($sql,array($question_id))->row_array();
    }

    /**
     * Return count of used types for quiz
     * @return int
     */
    public function getQuizTypesCount()
    {
        $sql = 'select count(distinct type_id) as amount from quiz_list';

        $row = $this->db->query($sql)->row_array();

        return $row['amount'];
    }

    /**
     * Sort questions.
     *
     * @param array $sortables
     * @param int $quiz_id
     * @return void
     */
    public function sortQuestions($sortables,$quiz_id)
    {
        $this->c_table = 'quiz_questions';

        parent::Sort($sortables,array('quiz_id'=>$quiz_id));
    }

	
	// === Dashboard: Start === //
    /**
     * Generate widget for dashboard.
     *
     * @return string
     */
    public function dashboardWidget()
    {
    	$widget = parent::dashboardWidget();
    	
    	$widget['content'] .= "
    	<p>
    		".$this->CI->filters_model->filterAnchorByCode('active_quizes',language('amount_of_active'),'quiz')." - ".$this->count(array('active'=>1))."
    	</p>
    	";
    	
    	return $widget;
    }
    // === Dashboard: End === //
}