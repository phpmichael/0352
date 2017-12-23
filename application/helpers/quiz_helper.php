<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Return answer title.
 *
 * @param array $answer
 * @param bool|int $aIndex
 * @return string
 */
function quiz_answer($answer, $aIndex=FALSE)
{
    if(preg_match('/^\[X\]/',$answer['answer']))//if start from [X]
    {
        if($aIndex!==FALSE) return lang_chr($aIndex);
        return '';
    }
    return htmlspecialchars($answer['answer']);
}