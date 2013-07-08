<?php
require("config.php");
$conn = mysql_connect($dbhost, $dbuser, $dbpassword);
mysql_select_db($dbdatabase, $conn);
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Geolocation</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link href="/maps/documentation/javascript/examples/default.css" rel="stylesheet">
    <!--
    Include the maps javascript with sensor=true because this code is using a
    sensor (a GPS locator) to determine the user's location.
    See: https://developers.google.com/apis/maps/documentation/javascript/basics#SpecifyingSensor
    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo API_KEY; ?>&sensor=TRUE"></script>

    <script>
var map;

function initialize() {
  var mapOptions = {
    zoom: 6,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  <?php
  $geosql = "SELECT * FROM visitor_map;";
  $georesult = mysql_query($geosql);
  
  while($georow = mysql_fetch_array($georesult))
  {
	  ?>
	  var lat = <?php echo $georow['latitude']; ?>
	  var lon = <?php echo $georow['longitude']; ?>
	  
	  var pos = new google.maps.LatLng(lat, lon);
	  
	  var infowindow = new google.maps.InfoWindow({
		  map: map,
		  position: pos,
		  content = <?php $georow['city']; ?>
	  });
	  
	  map.setCenter(pos);
	  
	  <?php
  }
  ?>
}

google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>
