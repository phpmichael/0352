<?
$phone1 = $BC->settings_model['site_phone1'];
$phone2 = $BC->settings_model['site_phone2'];
$phone3 = $BC->settings_model['site_phone3'];

for($i=1; $i<=3; $i++){
    $operator = '';
    preg_match('/^\((\d{3})\)/', ${'phone'.$i}, $matches);

    if( !empty($matches) )
    {
        $code = $matches[1];
        if(in_array($code,array('039', '067', '068', '096', '097', '098' ))) $operator = 'Kyivstar';
        elseif(in_array($code,array('050', '066', '095', '099' ))) $operator = 'MTC';
        elseif(in_array($code,array('063', '093'))) $operator = 'life :)';
    }

    ${'phone'.$i} = preg_replace('/[\d\-]{9}$/','<span class="phone-highlight">\\0</span>', ${'phone'.$i} );
    if( !empty($operator) ) ${'phone'.$i} .= ' <span class="phone-operator">'.$operator.'</span>';
}
?>

<div class="span6">
    <h3><?=language('contact_information')?></h3>

    <div class="pull-left email-icon"></div>
    <div class="pull-left">
        <a href="contact_us">E-mail</a>
    </div>

    <div class="clearfix"></div>

    <div class="pull-left mobile-icon"></div>
    <div class="pull-left">
        <div class="phone-number"><?=$phone1?></div>
        <div class="phone-number"><?=$phone2?></div>
        <div class="phone-number"><?=$phone3?></div>
    </div>
</div>

<div class="span6">
    <h3><?=language('schedule_call_center')?></h3>
    <div class="call-center-row"><em><?=lang('cal_mo')?>-<?=lang('cal_sa')?></em>: <?=sprintf( language('from_x_till_x'), '<strong>8:00</strong>', '<strong>21:00</strong>' )?></div>
    <div class="call-center-row"><em><?=lang('cal_sunday')?></em>: <?=sprintf( language('from_x_till_x'), '<strong>10:00</strong>', '<strong>19:00</strong>' )?></div>
</div>