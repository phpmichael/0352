<div class="section-3 clearfix">
	<div class="region region-header">
		<div id="block-views-slider-block" class="block block-views">
		
			<div id="slider">
			
				<?
					$slideshow = load_model('slideshow_model');
					$slides = $slideshow->getAll();
				?>
			
				<?foreach ($slides as $slide):?>
				<div>
					<div>
						<div>
							<div><img src="<?=base_url()?>images/data/m/slideshow/<?=$slide['image']?>" alt="<?=htmlspecialchars($slide['title'])?>" /></div>
						</div>
	
						<div class="views-field-title">
							<a href="<?=$slide['link']?>"><?=htmlspecialchars($slide['title'])?></a>
						</div>
	
						<div class="views-field-body">
							<?=htmlspecialchars($slide['description'])?>
						</div>
	
						<div class="views-field-view-node">
							<a href="<?=$slide['link']?>">Детальніше</a>
						</div>
					</div>
				</div>
				<?endforeach?>
			
			</div>
		
		</div><!-- /.block -->

		<div id="block-block-6" class="block block-block block-odd">
			<div class="content">
				<ul>
					<?
					$articles_categories_model = load_model('articles_categories_model');
					$articles_categories = $articles_categories_model->getChildren();
					?>
				
					<?foreach ($articles_categories as $article_category_id=>$article_category_title):?>
					<li><a href="<?=base_url('articles/index/category/'.$article_category_id)?>"><span></span><?=htmlspecialchars($article_category_title)?></a></li>
					<?endforeach?>
				</ul>
			</div><!-- /.content -->
		</div><!-- /.block -->
	</div>
</div><!-- /.section -->
<!-- /.section -->

<div class="section-4 clearfix">
	<div class="region region-header-bottom">
		<div id="block-views-services-block">
			<div class="content">
				<div class="view view-services view-id-services view-display-id-block view-dom-id-3">
					<div class="view-content">
					
						<?
						$products_categories_model = load_model('products_categories_model');
						$mainCategoriesArr = $products_categories_model->getChildren(0,TRUE);
						?>
					
						<?$i=0; foreach ($mainCategoriesArr as $category): $i++; ?>
						<div class="views-row views-row-<?=$i?>">
							<div class="views-field views-field-body">
							
								<div style="position:relative;">
									<a href="<?=site_url('assortment/index/category/'.$category['id'])?>"><img src="<?=base_url()?>images/data/s/products_categories_list/<?=$category['file_name']?>" width="210" height="160" alt="<?=htmlspecialchars($category['alt'])?>" /></a>
									<div class="image-overlay">
									   <div><span><?=$category['category']?></span></div>
								    </div>
								</div>
								
								<div>
								    <?=nl2br(word_limiter($category['description'],20))?>
								</div>
							</div>

							<div class="views-field-view-node">
								<span><a href="<?=site_url('assortment/index/category/'.$category['id'])?>">Детальніше</a></span>
							</div>
						</div>
						<?endforeach?>
						
					</div>
				</div>
			</div><!-- /.content -->
		</div><!-- /.block -->
	</div>
</div><!-- /.section -->
<!-- /.section -->