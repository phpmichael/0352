<?
$tags = $BC->tags_model->getPostTags($BC->_getCurrentTable(),$post_id);
if(!empty($tags)):?>
    <p class='post-tags'><?=language('tags')?>: 
    <?foreach($tags as $tag):?>
        <?=anchor($BC->_getBaseURI().'/tag/'.$tag['tag'],$tag['tag']).', '?>
    <?endforeach;?>
    </p>
<?endif?>