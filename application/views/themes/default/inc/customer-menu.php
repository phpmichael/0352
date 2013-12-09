<?if($tpl_page!='customers_home'):?>
<div class="accountBox">
	<ul>
		<li><?=anchor_base('customers', language('my_account'))?></li>
		<li><?=anchor_base('customers/editinfo', language('edit_my_info'))?></li>
		<li><?=anchor_base('quiz/my', language('my_quiz_results'))?></li>
		
		<!--
		<li><?=anchor_base('posters/my', language('my_posters'))?></li>
		<ul>
			<li><?=anchor_base('posters/add', language('add_poster'))?></li>
		</ul>
		<li><?=anchor_base('jobs/my', language('my_vacancies'))?></li>
		<ul>
			<li><?=anchor_base('jobs/add', language('add_vacancy'))?></li>
		</ul>
		-->
		
		<li><?=anchor_base('customers/signout', language('logout'))?></li>
	</ul>
</div>
<?endif?>