<div itemscope itemtype="http://schema.org/Book">
    <link itemprop="additionalType" href="http://schema.org/Product"/>

    <h1 itemprop="name"><?=$BC->_getPageTitle()?></h1>

    <div class="well">
        <table>
        <tr>
            <td style="width:50%; vertical-align: top;">
                <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                    <?=language('price')?>:
                    <span class="product-price" itemprop="price" content="<?=exchange($price,FALSE)?>">
                        <?=exchange($price)?>
                    </span>
                </div>

                <?if($old_price!=0.00):?>
                <div><?=language('old_price')?>: <span class="product-old-price"><?=exchange($old_price)?></span></div>
                <?endif?>

                <?if(@$photo1):?>
                <p>
                    <a href="<?=base_url().'images/data/b/books/'.$photo1?>" class="product-image" data-lightbox="product-image">
                        <?=img(array('src'=>'images/data/b/books/'.$photo1, 'height'=>'60%', 'width'=>'60%', 'alt'=>htmlspecialchars($name)))?>
                    </a>
                </p>
                <?endif?>

            </td>
            <td style="width:50%">
                <form action="<?=relative_url($BC->_getBaseURL()."/cart/add")?>" class="add-product">
                    <?=form_hidden('id',$data_key)?>

                    <div>

                        <?if($in_stock):?>

                            <?=form_input('qty',1,"size='1' class='input-mini' style='margin:0;'")?>

                            <?=form_submit('add_to_cart',language('buy'),"class='btn btn-primary'")?>

                        <?else:?>

                            <p><span class="badge badge-important"><?=language('not_in_stock')?></span></p>

                        <?endif?>

                        <div style="height:10px"></div>

                        <p>
                            <strong>ISBN:</strong>
                            <span itemprop="isbn"><?=$ISBN?></span>
                        </p>

                        <?if($author):?>
                        <p>
                            <strong><?=fb_input_label("author","books")?>:</strong>
                            <span itemprop="author"><?=$author?></span>
                        </p>
                        <?endif?>

                        <?if($language):?>
                        <p>
                            <strong><?=fb_input_label("language","books")?>:</strong>
                            <span itemprop="inLanguage"><?=fb_answers($language)?></span>
                        </p>
                        <?endif?>

                        <?if($year):?>
                        <p>
                            <strong><?=fb_input_label("year","books")?>:</strong>
                            <span itemprop="datePublished"><?=$year?></span>
                        </p>
                        <?endif?>

                        <?if($number_of_pages):?>
                        <p>
                            <strong><?=fb_input_label("number_of_pages","books")?>:</strong>
                            <span itemprop="numberOfPages"><?=$number_of_pages?></span>
                        </p>
                        <?endif?>

                        <?if($cover):?>
                        <p><strong><?=fb_input_label("cover","books")?>:</strong> <?=fb_answers($cover)?></p>
                        <?endif?>

                        <?if($manufacturer):?>
                        <p>
                            <strong>
                                <?=fb_input_label("manufacturer_id","books")?>:
                                <span itemprop="publisher">
                                    <?=anchor_base('books/search/manufacturer/'.urlencode($manufacturer),$manufacturer,'rel="nofollow"')?>
                                </span>
                            </strong>
                        </p>
                        <?endif?>

                        <?if(@$sample):?>
                        <p>
                            <a href="<?=base_url().'images/data/files/books/'.$sample?>" target="_blank">
                                Фрагмент для ознайомлення (~<?=round(filesize('./images/data/files/books/'.$sample)/1024)?> Kb PDF)
                            </a>
                        </p>
                        <?endif?>

                    </div>
                 </form>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <div class="additional-images">
                    <?if(@$photo2):?>
                    <a href="<?=base_url().'images/data/b/books/'.$photo2?>" class="product-image" data-lightbox="product-image">
                        <?=img(array('src'=>'images/data/s/books/'.$photo2))?>
                    </a>
                    <?endif?>

                    <?if(@$photo3):?>
                    <a href="<?=base_url().'images/data/b/books/'.$photo3?>" class="product-image" data-lightbox="product-image">
                        <?=img(array('src'=>'images/data/s/books/'.$photo3))?>
                    </a>
                    <?endif?>

                    <?if(@$photo4):?>
                    <a href="<?=base_url().'images/data/b/books/'.$photo4?>" class="product-image" data-lightbox="product-image">
                        <?=img(array('src'=>'images/data/s/books/'.$photo4))?>
                    </a>
                    <?endif?>

                    <?if(@$photo5):?>
                    <a href="<?=base_url().'images/data/b/books/'.$photo5?>" class="product-image" data-lightbox="product-image">
                        <?=img(array('src'=>'images/data/s/books/'.$photo5))?>
                    </a>
                    <?endif?>
                </div>
            </td>
        </tr>
        </table>

        <div>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab-description" aria-controls="tab-description" role="tab" data-toggle="tab"><?=fb_input_label("description","books")?></a></li>
                <li role="presentation"><a href="#tab-contents" aria-controls="tab-contents" role="tab" data-toggle="tab"><?=fb_input_label("contents","books")?></a></li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab-description" itemprop="description">
                    <?=$description?>
                </div>
                <div role="tabpanel" class="tab-pane" id="tab-contents">
                    <?=$contents?>
                </div>
            </div>
        </div>

    </div>
</div>