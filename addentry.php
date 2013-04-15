<?php
require("header.php");
?>

<h1>Add new entry</h1>
<form action="addentry.php" method="post">
<table>
<tr>
	<td>Category</td>
	<td>
		<select name="cat">
			<?php
			$catsql = "SELECT * FROM categories;";
			$catres = mysql_query($catsql);
			while($catrow=mysql_fetch_assoc($catres)) {
				echo "<option value='" . $catrow['id'] . "'>" . $catrow['cat'] . "</option>";
			}
			?>
		</select>
	</td>
</tr>
<tr>
	<td>Subject</td>
	<td><input type="text" name="subject"></td>
</tr>
<tr>
	<td>Body</td>
	<td><textarea name="body" rows="10" cols="50"></textarea></td>
</tr>
<tr>
	<td></td>
	<td><input type="submit" name="submit" value="Add Entry!"></td>
</tr>
</table>
</form>

<?php

if(isset($_SESSION['USERNAME']) == FALSE) {
	header("Location: " . $config_basedir);
}

if(isset($_POST['submit'])) {
	if($_POST['subject'] == "" || $_POST['body'] == "") {
		echo "Please enter both subject and body";
	}
	else {
		$sql = "INSERT INTO entries(usr_id, cat_id, dateposted, subject, body) VALUES('" . $_SESSION['USERID'] . "', " .
	$_POST['cat'] . ", NOW(), '" . $_POST['subject'] . "', '" .
	$_POST['body'] . "');";
	mysql_query($sql);
	header("Location: " . $config_basedir);
}
}
?>

<?php
require("footer.php");
?>


