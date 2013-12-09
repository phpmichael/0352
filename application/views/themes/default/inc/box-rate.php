<?if(isRatingsAllowed($table)):?>

    <div class="rating">
    	<?=language('rating')?>: <span id="rating-val-<?=$post_id?>-<?=$table?>"><?=$rating?></span>
    	<?if(!$already_rated):?>
    	<a href="javascript:void(0)" class="rating-inc" id="rating-inc-<?=$post_id?>-<?=$table?>" rel="<?=$table?>">+</a>
    	<a href="javascript:void(0)" class="rating-dec" id="rating-dec-<?=$post_id?>-<?=$table?>" rel="<?=$table?>">-</a>
    	<?endif?>
    </div>

<?endif?>