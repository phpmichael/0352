<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<?foreach (array(1,2,3) as $typeId):?>
    <p>
        <a href='<?=site_url($BC->_getBaseURL().'quiz/index/type/'.$typeId);?>'>Type <?=$typeId?></a>
    </p>
<?endforeach;?>