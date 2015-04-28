<h2><?=$BC->_getPageTitle()?></h2>

<table class="table table-bordered table-striped">
    <tbody>
    <tr>
        <?$i=0; foreach ($categories as $item): $i++?>

        <?if($i!=1 && !(($i-1)%3)):?></tr><tr><?endif?>

        <td width="33%" style="text-align:center">

            <p>
                <?=anchor_base("{$controller}/index/category/".$item['id'],$item['category'])?>
            </p>

            <?if(@$item['file_name']):?>
                <p>
                    <a title="<?=htmlspecialchars($item['category'])?>" href="<?=site_url($BC->_getBaseURL()."store/{$controller}/".$item['id'])?>">
                        <?=img('images/data/s/quiz_categories_list/'.$item['file_name'])?>
                    </a>
                </p>
                <p><?=nl2br(htmlspecialchars($item['description']))?>
            <?endif?>

        </td>

        <?endforeach;?>

        <?while($i%3):$i++?><td width="33%"></td><?endwhile?>
    </tr>
    </tbody>
</table>

