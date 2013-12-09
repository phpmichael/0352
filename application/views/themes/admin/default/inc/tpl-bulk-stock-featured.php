<?if(userAccess($BC->_getController(),'edit')):?>
    |
    <a href="javascript:void(0)" onclick="$j('form[name=form]').attr('action','<?=aurl('setinstock')?>').submit();"><?=language('in_stock')?></a>
    |
    <a href="javascript:void(0)" onclick="$j('form[name=form]').attr('action','<?=aurl('setnotinstock')?>').submit();"><?=language('not_in_stock')?></a>
    |
    <a href="javascript:void(0)" onclick="$j('form[name=form]').attr('action','<?=aurl('setfeatured')?>').submit();"><?=language('featured')?></a>
    |
    <a href="javascript:void(0)" onclick="$j('form[name=form]').attr('action','<?=aurl('setnotfeatured')?>').submit();"><?=language('remove_from_featured')?></a>
<?endif?>