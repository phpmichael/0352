<?
$questionType = $BC->quiz_model->getQuestionType($quiz['question']['id']);

if($questionType === 'multi-radio')
{
    if(count($quiz['answers']) === count($quiz['connected_answers']))
    {
        $questionShowType = 'Завдання на встановлення правильної послідовності';
    }
    else
    {
        $questionShowType = 'Завдання на встановлення відповідності (логічні пари)';
    }
}
elseif($questionType === 'digits3')
{
    $questionShowType = 'Завдання з вибором трьох правильних відповідей із семи запропонованих варіантів відповіді';
}
elseif($questionType === 'radio')
{
    $questionShowType = 'Завдання з вибором однієї правильної відповіді';
}
else
{
    $questionShowType = '';
}
?>

<?if($questionShowType):?>
    <p>
        Тип завдання: <u><?=$questionShowType?></u>
    </p>
<?endif?>