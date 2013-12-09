<?$random_testimonial=random_testimonial()?>
<?if($random_testimonial):?>
<div class="module">
    <h3><span><span><?=language('testimonials')?></span></span></h3>

    <div class="boxIndent">
        <div class="wrapper">
            <blockquote><?=$random_testimonial['content']?></blockquote>
            <p><i><?=$random_testimonial['name']?></i></p>
        </div>
        <div><?=anchor_base('testimonials',language('all_testimonials'))?></div>
    </div>
</div>
<?endif?>