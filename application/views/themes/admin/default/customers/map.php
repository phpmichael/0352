<p>
    <input type="radio" name="markerClickMode" value="route" id="mode-route" checked>
    <label for="mode-route">Route</label>

    <input type="radio" name="markerClickMode" value="change-center" id="mode-change-center">
    <label for="mode-change-center">Change center</label>
</p>

<div id="map" style="width:100%; height:450px; border:1px solid grey"></div>

<script src="https://maps.googleapis.com/maps/api/js?key=<?=@$BC->settings_model['google_map_api_key']?>"></script>
<?=include_js($BC->_getFolder('js').'custom/customers/map.js')?>
<script>
    $j(document).ready(function(){
        customersMap.load();

        $j('input[name=markerClickMode]').click(function(){
            customersMap.marker.clickMode = this.value;
        });
    });
</script>
