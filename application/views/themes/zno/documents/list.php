<h1><?=$BC->_getPageTitle()?></h1>

<?if( $posts_list ):?>

    <?if($paginate):?>
        <div class="pagination">
            <p><?=language('page')?>: </p> <?=$paginate?>
        </div>
    <?endif?>

    <?if($total_rows):?>
        <ul>
            <?foreach ($posts_list as $row):?>
                <li>
                    <a href="<?=site_url($BC->_getBaseURL().'documents/download/'.$row->data_key)?>">
                        <?=htmlspecialchars($row->name)?>
                    </a>
                </li>
            <?endforeach;?>
        </ul>
    <?endif?>

    <?if($paginate):?>
        <div class="pagination">
            <p><?=language('page')?>: </p> <?=$paginate?>
        </div>
    <?endif?>

<?else:?>
    <h2><?=language('search_did_not_give_any_results')?></h2>
<?endif?>