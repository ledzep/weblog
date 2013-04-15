<?php
require("header.php");
?>

<h1>Sign up</h1>
<form action="register.php" method="post">
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
		<td><input type="submit" name="submit" value="Sign up"></td>
	</tr>
	</table>
</form>

<?php
if (isset($_POST['submit'])) {
	$user = $_POST['username'];
	$pass = $_POST['password'];
	$token = sha1($pass);
    if($user == "" || $pass == "") {
		echo "Please enter both username and password"; 
	}
	else {
		$sql = "SELECT * FROM logins WHERE username = '$user';";
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		if($row['username'] == $user) {
			echo "Username already exists";
		}
		else {
			$sqlinsert = "INSERT INTO logins(username, password) VALUES('$user', '$token');";
			mysql_query($sqlinsert);
			echo "User successfully registered, You may now login";
		}
	}
}
?>

<?php
require("footer.php");
?>

