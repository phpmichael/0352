<div id="map" style="width:100%; height:450px; border:1px solid grey"></div>

<script src="https://maps.googleapis.com/maps/api/js?key=<?=@$BC->settings_model['google_map_api_key']?>"></script>
<?=include_js($BC->_getFolder('js').'custom/customers/map.js')?>
<script>
    customersMap.load();
</script>
