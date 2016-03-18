<?if(
    $BC->_getController() == 'customers'
    ||
    in_array($BC->_getController(), array('articles', 'news')) && in_array($BC->_getMethod(), array('index', 'tag'))
):?>
    <meta name="robots" content="noindex">
<?endif?>