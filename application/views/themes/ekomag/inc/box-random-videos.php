<?$random_videos=random_videos(3)?>
<?if(!empty($random_videos)):?>
    <h2><?=language('videos')?></h2>

    <ul class="boxIndent">
    <?foreach ($random_videos as $video):?>
    <li>
        <?=anchor_base('videos/view/'.$video['data_key'],$video['title'])?>
    </li>
    <?endforeach?>
    </ul>
<?endif?>