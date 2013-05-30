<?php
include('ip2locationlite.class.php');

//load the class
$iplite = new ip2location_lite;
$iplite->setKey('8bdc8e62c7c1a13baab60b982fb9b37d9354672b7f01b5210c2bee51dc9a151c');

//Get errors and locations
$locations = $iplite->getCity($_SERVER['REMOTE_ADDR']);
$error = $iplite->getError();

//Getting the results
echo "<p>\n";
echo "<strong>First result</strong><br />\n";
if(!empty($locations) && is_array($locations)) {
	foreach($locations as $field => $val) {
		echo $field . ' : ' . $val . "<br />\n";
	}
}
echo "</p>\n";

//Show errors
echo "<p>\n";
echo "<strong>Dump of all errors</strong><br />\n";
if(!empty($errors) && is_array($errors)) {
	foreach ($errors as $error) {
		echo var_dump($error) . "<br /><br />\n";
	}
}
else {
	echo "No errors" . "<br />\n";
}
echo "</p>\n";

?>


