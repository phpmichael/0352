<?
$quizTypes = array(
    1 => 'Тести УЦОЯО 2010-2019',
    2 => 'Тести за програмою ЗНО 2020 <small>(більше 4000 тестів)</small>',
    3 => 'Тренажер ЗНО 2020',
    4 => 'Блок 4',
    5 => 'Блок 5'
)?>
<ul>
    <?foreach ($quizTypes as $quizTypeId => $quizTypeTitle):?>
    <li>
        <a href='<?=site_url($BC->_getBaseURL().'quiz/index/type/'.$quizTypeId);?>'>
            <?=$quizTypeTitle?>
        </a>
    </li>
    <?endforeach;?>
</ul>