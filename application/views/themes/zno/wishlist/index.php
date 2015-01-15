<h1><?=$BC->_getPageTitle()?></h1>

<?if( $wishlist ):?>
    <table class="table">
        <tr class="rowH">
            <th><?=language('thing_name')?></th>
            <th><?=language('price')?></th>
            <th><?=language('delete')?></th>
        </tr>
        <?foreach ($wishlist as $key=>$row):?>
        <tr class="row<?if($key%2):?>A<?else:?>B<?endif?>">
            <td><?=anchor_base('book/'.$row['product']['slug'],$row['product']['name'],"class='product_name'")?></td>
            <td><?=exchange($row['product']['price'])?></td>
            <td><?=anchor($BC->_getBaseURI().'/remove/'.$row['id'],language('delete'))?></td>
        </tr>
        <?endforeach;?>
    </table>
<?else:?>
    <h2><?=language('your_wishlist_is_empty')?></h2>
<?endif?>