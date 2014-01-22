<?=include_js($BC->_getFolder('js').'highcharts/highcharts.js')?>

<?if(isset($chart_theme) && $chart_theme):?>
	<?=include_js($BC->_getFolder('js').'highcharts/themes/'.$chart_theme.'.js')?>
<?endif?>

<?
if(!isset($chart_type)) $chart_type = 'column';
if(!isset($chart_height)) $chart_height = 550;
?>

 <style>
	#chart-settings{
		margin:10px 0;
	}
	#chart-container{
		height:<?=$chart_height?>px;
	}
</style>

<script>
//<![CDATA[
var chart;
$j(document).ready(function() {
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'chart-container',
			type: '<?=$chart_type?>'
		},
		title: {
			text: '<?=htmlspecialchars($title)?>'
		},
		subtitle: {
			text: '<?=htmlspecialchars($subtitle)?>'
		},
		xAxis: {
			categories: [<?$i=0; foreach ($items as $item): $i++;?>'<?=$item['name']?>'<?if($i<count($items)):?>,<?endif?><?endforeach?>],
			title: {
				text: null
			}
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Amount',
				align: 'high'
			},
			labels: {
				overflow: 'justify'
			}
		},
		tooltip: {
			/*formatter: function() {
				//console.log(this);
				return ''+
					this.series.name +': '+ this.y +' millions';
			}*/
			/*formatter: function() {
				return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
			}*/
		},
		plotOptions: {
			bar: {
				dataLabels: {
					enabled: true
				}
			},
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: true,
					color: '#000000',
					connectorColor: '#000000',
					formatter: function() {
						//console.log(this);
						return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
					}
				}
			}
		},
		legend: {
			layout: 'vertical',
			align: 'right',
			verticalAlign: 'top',
			x: -100,
			y: 100,
			floating: true,
			borderWidth: 1,
			backgroundColor: '#FFFFFF',
			shadow: true
		},
		credits: {
			enabled: false
		},
		
		series: [
			<?$j=0; foreach ($groups as $group): $j++;?>
			{
				name: '<?=$group?>',
				data: [<?$i=0; foreach ($items as $item): $i++;?><?=intval(@$item['amounts'][$group])?><?if($i<count($items)):?>,<?endif?><?endforeach?>]
			}
			<?if($j<count($groups)):?>,<?endif?>
			<?endforeach?>
		]
	});
});
//]]>
</script>

<div id="chart-settings">
	<?=form_open()?>
		<?=language('theme')?>:
		<select name="chart_theme">
			<option value="">Default</option>
			<option value="gray" <?if(@$chart_theme=='gray'):?>selected="selected"<?endif?>>Gray</option>
			<option value="dark-blue" <?if(@$chart_theme=='dark-blue'):?>selected="selected"<?endif?>>Dark Blue</option>
			<option value="dark-green" <?if(@$chart_theme=='dark-green'):?>selected="selected"<?endif?>>Dark Green</option>
			<option value="grid" <?if(@$chart_theme=='grid'):?>selected="selected"<?endif?>>Grid</option>
			<option value="skies" <?if(@$chart_theme=='skies'):?>selected="selected"<?endif?>>Skies</option>
		</select>
		
		<?=language('type')?>:
		<select name="chart_type">
			<option value="bar">Bar</option>
			<option value="column" <?if(@$chart_type=='column'):?>selected="selected"<?endif?>>Column</option>
			<option value="pie" <?if(@$chart_type=='pie'):?>selected="selected"<?endif?>>Pie</option>
			<option value="line" <?if(@$chart_type=='line'):?>selected="selected"<?endif?>>Line</option>
			<option value="area" <?if(@$chart_type=='area'):?>selected="selected"<?endif?>>Area</option>
		</select>
		
		<input type="checkbox" name="rotate" value="1" <?if(@$rotate):?>checked="checked"<?endif?> /> Rotate X/Y
		
		<?=language('height')?>: <input type="text" name="chart_height" value="<?=$chart_height?>" />
		
		<input type="submit" value="<?=language('change')?>" />
	</form>
</div>

<div id="chart-container"></div>