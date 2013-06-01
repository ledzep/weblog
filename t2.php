<?php
include('ip2locationlite.class.php');
$iplite = new ip2location_lite;
$iplite->setKey('8bdc8e62c7c1a13baab60b982fb9b37d9354672b7f01b5210c2bee51dc9a151c');
$locations = $iplite->getCity($_SERVER['REMOTE_ADDR']);
$error = $iplite->getError();

$latitude = 0.0
$longitude = 0.0

// If there are errors, show them.
echo "<p>\n";
echo "<strong>Dump of all errors</strong><br />\n";
if(!empty($errors) && is_array($errors)) {
	foreach ($errors as $error) {
		echo var_dump($error) . "<br /><br />\n";
	}
} else {
	// Use the first location returned.
	$latitude = $locations["latitude"];
	$longitude = $locations["longitude"];
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body, #map-canvas {
        margin: 0;
        padding: 0;
        height: 100%;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script>
    var map;
    function initialize() {
	    var mapOptions = {
	      zoom: 8,
	      center: new google.maps.LatLng(-34.397, 150.644),
	      mapTypeId: google.maps.MapTypeId.ROADMAP
	    };
	    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

            // Use the lat long computed by PHP above to set position.
            var lat = "<?php echo $latitude ?>";
            var long = "<?php echo $longitude ?>";
	    var pos = new google.maps.LatLng(lat, long);

	    var infowindow = new google.maps.InfoWindow({
		map: map,
		position: pos,
		content: 'Test location'
	      });
	    map.setCenter(pos);
    }
    google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>

Sir gandhiji chitragupt se puchta hai mere teen bandaro ke kya haal hai. woh bolta hai sab maje mein hai. andha kanun hogaya hai, behra sarkar ho gaya hai aur gungey ne to haad kardi hai, aajkal PM bana baitha hai 
