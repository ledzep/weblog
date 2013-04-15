<?php
require("header.php");
?>

<form action="login.php" method="post">
<table>
	<tr>
		<td>Username</td>
		<td><input type="text" name="username"></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input type="password" name="password"></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="submit" value="Login!"></td>
	</tr>
</table>
</form>

<?php 
//session_start();

require("config.php");
$db = mysql_connect($dbhost, $dbuser, $dbpassword);
mysql_select_db($dbdatabase, $db);

if(isset($_POST['submit'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$temp = sha1($password);
	$sql = "SELECT * FROM logins WHERE username = '$username' AND password = '$temp';";
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);
	
	if($numrows == 1) {
		$row = mysql_fetch_assoc($result);
		//session_register("USERNAME");
		//session_register("USERID");
		
		$_SESSION['USERNAME'] = $row['username'];
		$_SESSION['USERID'] = $row['id'];
		
		//header("Location: http://www.google.com");
		header("Location: " . $config_basedir);
	}
	else {
		header("Location: " . $config_basedir . "/login.php?error=1");
	}
}
else {
	
	if(isset($_GET['error'])) {
		echo "Incorrect login, please try again!";
	}
}
?>

<?php
require("footer.php");
?>
