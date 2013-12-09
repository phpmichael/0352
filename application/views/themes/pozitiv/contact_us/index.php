
    <h1><?=$BC->_getPageTitle()?></h1>
    
    <div>
	<?
	$contact_page = $BC->pages_model->getByLink('contact_us');
	echo $contact_page['body'];
	?>
	</div>
	
	<hr />

    <div style="width:400px;float:left;">
    
        <p class="required">* <?=language('required_fields')?></p>
        <div class="green" id="success"></div>
        <div class="red" id="errors"></div>
        
        <form id="contact_form" action="#" method="post">
            <div class="fieldset">
                <p>
                	<?=$BC->_getFieldTitle("name")?> &nbsp;
                	<input type="text" name="name" value="" size="45" />
                </p>
                <p>
                	<?=$BC->_getFieldTitle("email")?>
                	<input type="text" name="email" value="" size="45" />
                </p>
                <p>
                	<?=$BC->_getFieldTitle("message")?> <br />
                	<textarea name="message" rows="7" cols="45"></textarea>
                </p>
                
                <p><?=$cap_img?></p>
                <p>
                	<?=$BC->_getFieldTitle("captcha")?>: <br />
                	<input type="text" name="captcha" value="" />
                </p>
                
                <p>
                    <?=form_submit('submit',language('submit'))?>
                </p>
               
            </div>
        </form>
    </div>
    
    <div id="YMapsLocation1" style="width:400px;height:400px;float:left;"></div>
    
    <div style="clear:both"></div>

<!-- Load Application Packeges config -->
<?=include_js($BC->_getBaseURL().'app_js/config')?>

<?=include_js($BC->_getFolder('js').'custom/contact_us/send_form.js')?>

<!-- Yandex Map -->
<script src="http://api-maps.yandex.ru/1.1/index.xml?key=AOGNyE8BAAAAr-i4MAMAf1KwwwqGQGOJQAzkUDOj3qL02bQAAAAAAAAAAAAIjSCwZnNdKjTiVm-wOZ0qmPyGzQ==" type="text/javascript"></script>

<script type="text/javascript">
//<![CDATA[
	YMaps.jQuery(function () {
		var mapPlgPM1 = new YMaps.Map(document.getElementById("YMapsLocation1"));
		mapPlgPM1.setCenter(new YMaps.GeoPoint( 25.600081, 49.55113), 17);
		mapPlgPM1.enableDblClickZoom();
		mapPlgPM1.enableScrollZoom();
		mapPlgPM1.addControl(new YMaps.Zoom());
		mapPlgPM1.addControl(new YMaps.ScaleLine());
		mapPlgPM1.addControl(new YMaps.TypeControl());
		
		var pointPlgPM1 = new YMaps.Placemark(new YMaps.GeoPoint(25.600081, 49.55113));
		pointPlgPM1.setIconContent();
		mapPlgPM1.addOverlay(pointPlgPM1);
		pointPlgPM1.setBalloonContent('<div style="color:black"><h3>Фотостудія «Позитив»</h3><div>м. Тернопіль, вул. Руська 52/2</div></div>', {maxWidth: 100});
		pointPlgPM1.openBalloon();
	});
//]]>
</script>