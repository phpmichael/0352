<?$random_testimonial=random_testimonial()?>
<?if($random_testimonial):?>
<div id="random-testimonial">
    <h3><?=language('testimonials')?></h3>
    <blockquote><?=$random_testimonial['content']?></blockquote>
    <p><i><?=$random_testimonial['name']?></i></p>
</div>
<?endif?>