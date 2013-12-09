<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<div class="accountBox">
	<ul>
		<li><?=anchor_base('customers/editinfo', language('edit_my_info'))?></li>
		<li><?=anchor_base('quiz/my', language('my_quiz_results'))?></li>
		
		<!--
		<li><?=anchor_base('posters/my', language('my_posters'))?> | <?=anchor_base('posters/add', language('add_poster'))?></li>
		<li><?=anchor_base('jobs/my', language('my_vacancies'))?> | <?=anchor_base('jobs/add', language('add_vacancy'))?></li>
		-->
		
		<li><?=anchor_base('customers/signout', language('logout'))?></li>
	</ul>
</div>