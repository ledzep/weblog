<?php
// connection to mysql

require("config.php");
$conn = mysql_connect($dbhost, $dbuser, $dbpassword);
mysql_select_db($dbdatabase, $conn);
?>

<html>
 <head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
 <script src="http://maps.google.com/maps/api/js?v=3&sensor=false" type="text/javascript"></script>
 <script type="text/javascript">
 //Sample code written by August Li
 var icon = new google.maps.MarkerImage("http://maps.google.com/mapfiles/ms/micons/blue.png",
 new google.maps.Size(32, 32), new google.maps.Point(0, 0),
 new google.maps.Point(16, 32));
 var center = null;
 var map = null;
 var currentPopup;
 var bounds = new google.maps.LatLngBounds();
function addMarker(lat, lng, info) {
	 var pt = new google.maps.LatLng(lat, lng);
	 bounds.extend(pt);
	 var marker = new google.maps.Marker({
		 position: pt,
		 icon: icon,
		 map: map
	 });
	 var popup = new google.maps.InfoWindow({
		 content: info,
		 maxWidth: 300
	 });
	 google.maps.event.addListener(marker, "click", function() {
		 if (currentPopup != null) {
			 currentPopup.close();
			 currentPopup = null;
		 }
		 popup.open(map, marker);
		 currentPopup = popup;
	 });
	 google.maps.event.addListener(popup, "closeclick", function() {
		 map.panTo(center);
		 currentPopup = null;
	 });
}
function initMap() {
	 map = new google.maps.Map(document.getElementById("map"), {
		 center: new google.maps.LatLng(0, 0),
		 zoom: 14,
		 mapTypeId: google.maps.MapTypeId.ROADMAP,
		 mapTypeControl: false,
		 mapTypeControlOptions: {
			 style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR
		 },
		 navigationControl: true,
		 navigationControlOptions: {
			 style: google.maps.NavigationControlStyle.SMALL
		 }
	 });
	 <?
	 $geosql = "SELECT * FROM visitor_map WHERE blog_id = " $validentry;
	 $georesult = mysql_query($geosql);

	 while($georow = mysql_fetch_array($georesult)) {
		 $city = $georow['city'];
		 $lat = $georow['latitude'];
		 $lon = $georow['longitude'];
		 $region = $georow['region'];
		 $country = $georow['country'];
		 echo ("addMarker($lat, $lon,'<b>$city</b><br/><b>$region</b><br/>$country');\n");
	 }
	 ?>
	 center = bounds.getCenter();
	 map.fitBounds(bounds);

}
<?php
$commsql = "SELECT * FROM comments WHERE blog_id = " . $validentry . "
			ORDER BY dateposted DESC;";
$commresult = mysql_query($commsql);
$numrows_comm = mysql_num_rows($commresult);
if($numrows_comm) {
	?>
    google.maps.event.addDomListener(window, 'load', initMap);
    <?php
}
?>
</script>
</head>
<div id="map"></div>
</html>
  
