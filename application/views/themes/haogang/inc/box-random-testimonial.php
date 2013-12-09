<?$random_testimonial=random_testimonial()?>
<?if($random_testimonial):?>
<div class="corner">
    <div class="full-width">
        <div class="block-title">
            <strong><span><?=language('testimonials')?></span></strong>
        </div>

        <div class="block-content">
            <blockquote><?=$random_testimonial['content']?></blockquote>
            <p><i><?=$random_testimonial['name']?></i></p>
        </div>
    </div>
</div>
<?endif?>