<?php

require("config.php");
require("ip2locationlite.class.php");

if (isset($_GET['id']) == TRUE) {
	if (is_numeric($_GET['id']) == FALSE) {
		$error = 1;
	}
	
	if (isset($error)) {
		header("Location: " . $config_basedir);
	}
	else  {
		$validentry = $_GET['id'];
	}
}
else {
	$validentry = 0;
}
?>


<?php
require("header.php");

if($validentry == 0) {
	$sql = "SELECT entries.*, categories.cat FROM entries, categories
		WHERE entries.cat_id = categories.id
		ORDER BY dateposted DESC
		LIMIT 1;";
}
else {
	$sql = "SELECT entries.*, categories.cat FROM entries, categories
		WHERE entries.cat_id = categories.id AND entries.id = " . $validentry . "
		ORDER BY dateposted DESC LIMIT 1;";
}
$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);
echo "<h2>" . $row['subject'] . "</h2><br />";
echo "<i>In <a href='viewcat.php?id=" . $row['cat_id'] . "'>" . $row['cat'] . "</a> - Posted on " . date("D jS F Y g.iA", strtotime($row['dateposted'])) . "</i>";
echo "<p>";
$text = $row['body'];
//echo nl2br($text);
//echo nl2br($row['body']);
//$text = $row['body'];
$rows = explode(' ', $text);
foreach ($rows AS $key => $value) {
	if (preg_match("/^([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/", $value)) {
		if (!preg_match('@^https?://@i', $value)) {
			$value = 'http://' . $value;
		}
		$rows[$key] = '<a href="' . $value . '" target="_blank">' . $rows[$key] . '</a>';
	}
}			
$text = implode(' ', $rows);
echo nl2br ($text);
echo "</p>";

$commsql = "SELECT * FROM comments WHERE blog_id = " . $validentry . "
			ORDER BY dateposted DESC;";
$commresult = mysql_query($commsql);
$numrows_comm = mysql_num_rows($commresult);

$geosql = "SELECT latitude, longitude FROM visitor_map WHERE blog_id = " . $validentry;
$georesult = mysql_query($geosql);

if($numrows_comm == 0) {
	echo "<p>No comments. </p>";
}
else {
	$i = 1;
	while(($commrow = mysql_fetch_assoc($commresult)) and ($georow = mysql_fetch_assoc($georesult))) {
		echo "<a name='comment" . $i . "'>";
		echo "<h4>Comment by " . $commrow['name'] . " on " . date("D jS F Y g.iA", strtotime($commrow['dateposted'])) . ", from " . ucwords(strtolower($georow['city'])) . "/" . ucwords(strtolower($georow['region'])) . "/" . ucwords(strtolower($georow['country'])) . "</h4>";
		echo nl2br($commrow['comment']);
		$i++;
	}
}
?>

<?php
if(isset($_SESSION['USERNAME'])) {
	?>
<h3>Leave a comment</h3>
<form action="<?php echo $_SERVER['SCRIPT_NAME']
. "?id=" . $validentry; ?>" method="post">
<table>
	<!--<tr>
		<td>Your Name</td>
		<td><input type="text" name="name"></td>
	</tr>-->
	<tr>
		<td>Comments</td>
		<td><textarea name="comment" rows="10" cols="50"></textarea></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="submit" value="Add comment"></td>
	</tr>
</table>
</form>
	<?
}
?>

<?php
if(isset($_POST['submit'])) {
	$db = mysql_connect($dbhost, $dbuser, $dbpassword);
	mysql_select_db($dbdatabase, $db);
	
	$iplite = new ip2location_lite;
	$iplite->setKey('8bdc8e62c7c1a13baab60b982fb9b37d9354672b7f01b5210c2bee51dc9a151c');
	$locations = $iplite->getCity($_SERVER['REMOTE_ADDR']);
	$error = $iplite->getError();
	$longitude = 0.0;
	$latitude = 0.0;
	$cityname = "";
	$regionname = "";
	$countryname = "";
	if(empty($error)) {
		// there was no error, so get all the value
		$longitude = $locations['longitude'];
		$latitude = $locations['latitude'];
		$cityname = $locations['cityName'];
		$regionname = $locations['regionName'];
		$countryname = $locations['countryName'];
	}
	
	if($_POST['comment'] == "") {
		echo "Please enter something!!";
	}
	else {
		$sql = "INSERT INTO comments(user_id, blog_id, dateposted, name, comment) VALUES
                (" . $_SESSION['USERID'] . ", " . $validentry . "
                , NOW()
                , '" . $_SESSION['USERNAME'] . "'
                , '" . $_POST['comment'] . "'
                );";
		mysql_query($sql);
		
		$visitorsql = "INSERT INTO visitor_map(user_id, blog_id, city, region, country, longitude, latitude) VALUES
					(" . $_SESSION['USERID'] . ", " . $validentry . "
					, '" . $cityname . "', '" . $regionname . "', '" . $countryname . "', '" . $longitude . "', '" . $latitude . "');";
		mysql_query($visitorsql);
		
		header("Location: http://" . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'] . "?id=" . $validentry);
		//header("Location: http://www.google.com/"); 
	}
}
else {
	// code will go here
}
?>

<?php
require("footer.php");
?>
		

 

