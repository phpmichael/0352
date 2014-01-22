
    <h2><?=$BC->_getPageTitle()?></h2>
    
    <div>
	<?
	$contact_page = $BC->pages_model->getByLink('contact_us');
	echo $contact_page['body'];
	?>
	</div>
	
	<hr />
	
	<div id="YMapsLocation1" style="width:535px;height:300px"></div>
	<hr />
	<div id="YMapsLocation2" style="width:535px;height:300px"></div>
	
	<hr />

    <div class="boxIndent">
    
        <p class="required">* <?=language('required_fields')?></p>
        <div class="green" id="success"></div>
        <div class="red" id="errors"></div>
        
        <form id="contact_form" action="#" method="post">
            <div class="fieldset">
                <p>
                	<?=$BC->_getFieldTitle("name")?> <br />
                	<input type="text" name="name" value="" size="70" class="light-input" />
                </p>
                <p>
                	<?=$BC->_getFieldTitle("email")?> <br />
                	<input type="text" name="email" value="" size="70" class="light-input" />
                </p>
                <p>
                	<?=$BC->_getFieldTitle("message")?> <br />
                	<textarea name="message" rows="7" cols="60" class="light-input"></textarea>
                </p>
                
                <p><?=$cap_img?><br />&nbsp;</p>
                <p>
                	<?=$BC->_getFieldTitle("captcha")?>: <br />
                	<input type="text" name="captcha" value="" class="light-input" />
                </p>
                
                <p>
                    <?=form_submit('submit',language('submit'))?>
                </p>
               
            </div>
        </form>
    </div>


<?=include_js($BC->_getFolder('js').'custom/contact_us/send_form.js')?>

<!-- Yandex Map -->
<script src="http://api-maps.yandex.ru/1.1/index.xml?key=AOGNyE8BAAAAr-i4MAMAf1KwwwqGQGOJQAzkUDOj3qL02bQAAAAAAAAAAAAIjSCwZnNdKjTiVm-wOZ0qmPyGzQ=="></script>

<script>

	YMaps.jQuery(function () {
		var mapPlgPM1 = new YMaps.Map(document.getElementById("YMapsLocation1"));
		mapPlgPM1.setCenter(new YMaps.GeoPoint( 25.598963, 49.551108), 17);
		mapPlgPM1.enableDblClickZoom();
		mapPlgPM1.enableScrollZoom();
		mapPlgPM1.addControl(new YMaps.Zoom());
		mapPlgPM1.addControl(new YMaps.ScaleLine());
		mapPlgPM1.addControl(new YMaps.TypeControl());
		//mapPlgPM1.addControl(new YMaps.MiniMap());
		//mapPlgPM1.addControl(new YMaps.ToolBar());
		
		var pointPlgPM1 = new YMaps.Placemark(new YMaps.GeoPoint(25.598963, 49.551108));
		pointPlgPM1.setIconContent();
		mapPlgPM1.addOverlay(pointPlgPM1);
		pointPlgPM1.setBalloonContent('<h3>«ЕКОМАГ»</h3><div>вул. Руська 44, ("ЄВРОРИНОК")</div>', {maxWidth: 100});
		pointPlgPM1.openBalloon();
	});

	YMaps.jQuery(function () {
		var mapPlgPM2 = new YMaps.Map(document.getElementById("YMapsLocation2"));
		mapPlgPM2.setCenter(new YMaps.GeoPoint( 25.645693, 49.559802), 16);
		mapPlgPM2.enableDblClickZoom();
		mapPlgPM2.enableScrollZoom();
		mapPlgPM2.addControl(new YMaps.Zoom());
		mapPlgPM2.addControl(new YMaps.ScaleLine());
		mapPlgPM2.addControl(new YMaps.TypeControl());
		//mapPlgPM2.addControl(new YMaps.MiniMap());
		//mapPlgPM2.addControl(new YMaps.ToolBar());
		
		var pointPlgPM2 = new YMaps.Placemark(new YMaps.GeoPoint(25.645693, 49.559802));
		pointPlgPM2.setIconContent();
		mapPlgPM2.addOverlay(pointPlgPM2);
		pointPlgPM2.setBalloonContent('<h3>«ЕКОМАГ»</h3><div>вул. Стуса 1, ("Фуршет")</div>', {maxWidth: 100});
		pointPlgPM2.openBalloon();
	});

</script>