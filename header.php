<?php
session_start();
require("config.php");
$conn = mysql_connect($dbhost, $dbuser, $dbpassword);
mysql_select_db($dbdatabase, $conn);
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $config_blogname; ?></title>
		<!--<link rel="stylesheet" href="/murky/style.css" type="text/css" />-->
	</head>
	<body>
		<div id="header">
			<h1 align="center"><?php echo $config_blogname; ?></h1>
			[<a href="index.php">Home</a>] &bull;
			[<a href="viewcat.php">Categories</a>] &bull;
			
			<!--<a href="index.php" style="display: block; text-align: center;">home</a>
			<a href="viewcat.php" style="display: block; text-align: center;">categories</a>-->
			<?php
			if(isset($_SESSION['USERNAME']) == TRUE) {
				echo "[<a href='logout.php'>Logout (" . $_SESSION['USERNAME'] . ")</a>] &bull;";
				//echo "<a href='logout.php' style='display: block; text-align: center;'>logout</a>";
			}
			else {
				echo "[<a href='login.php'>Login</a>] &bull;";
				echo " [<a href='register.php'>Sign up</a>]";
				//echo "<a href='login.php' style='display: block; text-align: center;'>login</a>";
				//echo "<a href='register.php' style='display: block; text-align: center;'>Sign up!</a>";
			}
			
			if(isset($_SESSION['USERNAME']) == TRUE) {
				echo " [<a href='addentry.php'>add entry</a>]";
				//echo "<a href='addentry.php' style='display: block; text-align: center;'>add entry</a>";
				//echo "<a href='addcat.php' style='display: block; text-align: center;'>add category</a>";
			}
			?>
		</div>
		
	<div id="main">
		
