<?
load_model('products_manufacturers_model');
$manufacturers = $BC->zen->products_manufacturers_model->getManufacturersList();
?>

<?if(!empty($manufacturers)):?>
<h2 class="left-sidebar-toggle" role="button" tabindex="0" aria-expanded="true">
    <span class="toggle-arrow">&#9660;</span> <?=language('manufacturers')?>
</h2>

<div class="left-sidebar-content">
    <div class="well">

        <ul class="unstyled">
        <?foreach ($manufacturers as $manufacturer_id=>$manufacturer_name):?>
            <?if($manufacturer_id):?>
            <li>
                <?=anchor_base('books/search/manufacturer/'.urlencode($manufacturer_name),$manufacturer_name)?>
            </li>
            <?endif?>
        <?endforeach?>
        </ul>

    </div>
</div>
<?endif?>
