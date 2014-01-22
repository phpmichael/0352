<?$currency_model = load_model('currency_model')?>

<form class="set-currency" action="<?=relative_url($BC->_getBaseURL().'currency/set')?>" method="post">
	<label><?=language('currency')?>:</label>
	<?=form_dropdown('currency_code',$currency_model->getEnabledCurrenciesCodes(),$currency_model->getCurrentCurrencyCode())?>
</form>

<script>
$j(document).ready(function(){
	$j(".set-currency select[name=currency_code]").change(function(){
		$j(this).parent('form').submit();
	});
});
</script>