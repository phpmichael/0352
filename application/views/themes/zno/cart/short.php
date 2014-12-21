<?if($this->cart->total_items()):?>
    <p>
        <?=$this->cart->total_items()?> <?=language($items_in_cart_lang_code)?>
    </p>
    <p>
        <?=language('total')?>: <strong><?=exchange($this->cart->total())?></strong>
    </p>
    <p>
        <?=anchor($BC->_getBaseURI(),language('do_order'),"class='btn btn-primary'")?>
    </p>
<?else:?>
    <p>
        <?=language('your_cart_is_empty')?>
    </p>
<?endif?>