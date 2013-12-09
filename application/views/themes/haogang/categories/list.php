<div class="page-title category-title">
    <h1><?=$BC->_getPageTitle()?></h1>
</div>

<div class="category-products">

    <!-- Boxes Start -->
    <?$i=0; foreach ($categories as $item): $i++?>

        <?if($i%2):?><ul class="products-grid"><li class="item first"><?else:?><li class="item last"><?endif?>
    
            <div class="main-block">
            
                <div class="top-corners"><div><div>&nbsp;</div></div></div>
    
                <div class="corner">
                    <div class="full-width">
                        <div class="product-box">
                            <div class="ie-fix">
                            
                                <a title="<?=htmlspecialchars($item['category'])?>" href="<?=site_url($BC->_getBaseURL()."{$controller}/index/category/".$item['id'])?>" class="product-image">
                                	<?if(@$item['file_name']) echo img('images/data/s/products_categories_list/'.$item['file_name'])?>
                                </a>
                                
                                <br class="clear" />
                                
                                <h2 class="a-center">
                                    <?=anchor_base("{$controller}/index/category/".$item['id'],$item['category'])?>
                                </h2>
                                 
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="bot-corners"><div><div>&nbsp;</div></div></div>
            </div>
            
        <?if(!($i%2)):?></li></ul><?else:?></li><?endif?>
    
    <?endforeach;?>
    
    <?if($i%2):?></li></ul><?endif?>
    <!-- Boxes End -->
            
</div>