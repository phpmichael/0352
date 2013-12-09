<script type="text/javascript">
//<![CDATA[
$j(document).ready(
	function () {

		/* Hover */
		$j('li.sortable_item table.list tr').hover(
			function()
			{
				$j(this).addClass('hover');
			},
			function()
			{
				$j(this).removeClass('hover');
			}
		);

		/* Init Sortable */
		$j('ul#sortable_group').sortable(
			{
				items: '.sortable_item'
			}
		);

		/* Save Sortable */
		$j("#save").click(function(e){

			//Serialize from fields
			var sortables = $j('ul#sortable_group').sortable('serialize');

			/* Saving */
			$j.post(window.sort_process.save_sort_url, {sortables: sortables}, function(data) {
				document.location.href=window.sort_process.redirect_after_sort_url;
			});

			return false;
		});
	}
);
//]]>
</script>