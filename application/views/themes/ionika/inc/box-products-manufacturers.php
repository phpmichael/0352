<?
$products_manufacturers_model = load_model('products_manufacturers_model');
$manufacturers = $products_manufacturers_model->getManufacturersList();
?>

<div class="module">
    <h3><span><span><?=language('manufacturers')?></span></span></h3>

    <div class="boxIndent">
        <div class="wrapper">
            <div class="content">
                <?if(!empty($manufacturers)):?>
				<div class="item-list">
					<ul>
						<?foreach ($manufacturers as $manufacturer_id=>$manufacturer_name):?>
						<li>
							<?if($manufacturer_id) echo anchor_base('products/search/manufacturer/'.urlencode($manufacturer_name),$manufacturer_name)?>
						</li>
						<?endforeach?>
					</ul>
				</div>
			   <?endif?>
            </div>
        </div>
    </div>
</div>