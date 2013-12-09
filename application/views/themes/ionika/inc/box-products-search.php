<div class="search">
	<span class="label"><?=language('search')?>&nbsp;</span>
	
	<?if (!in_array($BC->_getController(),array('articles'))):?>
		<?=form_open($BC->_getBaseURL()."products/search")?>
	<?else:?>
		<?=form_open($BC->_getBaseURL()."articles")?>
	<?endif?>
			<div>	
			  <?=form_input("keywords",trim(urldecode(@$keywords)),"class='input1'")?> 						
			  <input type="image" src="<?=site_url($BC->_getTheme().'images/search.gif')?>" alt="Search" title=" Search " class="input2" />							
			</div>
		</form>
</div>