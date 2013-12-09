<?$random_testimonial=random_testimonial()?>
<?if($random_testimonial):?>
    <h2><?=language('testimonials')?></h2>

    <div class="boxIndent">
        <blockquote><?=$random_testimonial['content']?></blockquote>
        <p><i><?=$random_testimonial['name']?></i></p>
        <div><?=anchor_base('testimonials',language('all_testimonials'))?></div>
    </div>
<?endif?>