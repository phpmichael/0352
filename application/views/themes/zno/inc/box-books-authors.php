<?
load_model('books_authors_model');
$authors = $BC->zen->books_authors_model->getAuthorsList(10);
?>

<?if(!empty($authors)):?>
<h2>Автори</h2>

<div class="well">
    
	<ul class="unstyled">
	<?foreach ($authors as $author_name):?>
        <?$full_name = explode(' ', $author_name);//use in link just surname?>
		<li>
			<?=anchor_base('books/search/author/'.urlencode($full_name[0]), $author_name)?>
		</li>
	<?endforeach?>
	</ul>
   
</div>
<?endif?>
