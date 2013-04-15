<?php
require("header.php");
?>

<?php
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

if(isset($_POST['submit'])) {
	$sql = "UPDATE entries SET cat_id = "
	. $_POST['cat'] . ", subject = '" .
	$_POST['subject'] ."', body = '"
	. $_POST['body'] . "' WHERE id = " .
	$validentry . ";";
	
	mysql_query($sql);
	header("Location: " . $config_basedir . "/viewentry.php?id=" . $validentry);
}
else {
	$fillsql = "SELECT * FROM entries WHERE id = " . $validentry . ";";
	$fillres = mysql_query($fillsql);
	$fillrow = mysql_fetch_assoc($fillres);
}
?>

<h1>Update entry</h1>
<form action="<?php echo $_SERVER['SCRIPT_NAME']
. "?id=" . $validentry; ?>" method="post">
<table>
	<tr>
		<td>Category</td>
		<td>
			<select name="cat">
			<?php
			$catsql = "SELECT * FROM categories;";
			$catres = mysql_query($catsql);
			while($catrow=mysql_fetch_assoc($catres)) {
				echo "<option value='" . $catrow['id'] . "'";
				if($catrow['id'] == $fillrow['cat_id']) {
					echo " selected";
				}
				echo ">" . $catrow['cat'] . "</option>";
			}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Subject</td>
		<td><input type="text" name="subject" value="<?php echo $fillrow['subject'] ?>"></td>
	</tr>
	<tr>
		<td>Body</td>
		<td><textarea name="body" rows="10" cols="50"><?php echo $fillrow['body']; ?></textarea></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="submit" value="Update Entry!"></td>
	</tr>
</table>
</form>

<?php
require("footer.php");
?>


	
 
