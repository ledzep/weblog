<?php
function get_location($ip) {
	$content = @file_get_contents('http://api.hostip.info/?ip='.$ip);
	if ($content != FALSE) {
		$xml = new SimpleXmlElement($content);
		$coordinates = $xml->children('gml', TRUE)->featureMember->children('', TRUE)->Hostip->ipLocation->children('gml', TRUE)->pointProperty->Point->coordinates;
		$longlat = explode(',', $coordinates);
		$location['longitude'] = $longlat[0];
		$location['latitude'] = $longlat[1];
		$location['citystate'] = '==>'.$xml->children('gml', TRUE)->featureMember->children('', TRUE)->Hostip->children('gml', TRUE)->name;
		$location['country'] =  '==>'.$xml->children('gml', TRUE)->featureMember->children('', TRUE)->Hostip->countryName;
		return $location;
	}
	else return false;
}

$ip = $_SERVER['REMOTE_ADDR'];
$location_info = get_location($ip);
var_dump($location_info);

/*To access the longitude:
$location_info['longitude'];

To access the latitude:
$location_info['latitude'];

To access the city/state string:
$location_info['citystate'];

To access the country string:
$location_info['country'];*/

?>
