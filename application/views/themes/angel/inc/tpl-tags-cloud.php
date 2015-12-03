<?if($BC->_getController()=='photos'):?>
<div class="tag_cloud">
    <h2><?=language('tags_cloud')?></h2>
    <?=tags_cloud()?>
</div>
<?endif?>