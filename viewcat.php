<?php

require("config.php");

if(isset($_GET['id']) == TRUE) {
	if (is_numeric($_GET['id']) == FALSE) {
		$error = 1;
	}
	if(isset($error)) {
		header("Location: " . $config_basedir . "/viewcat.php");
	}
	else {
		$validcat = $_GET['id'];
	}
}
else {
	$validcat = 0;
}

require("header.php");

$sql = "SELECT * FROM categories";
$result = mysql_query($sql);

while($row = mysql_fetch_assoc($result)) {
	if($validcat == $row['id']) {
		echo "<strong>" . $row['cat'] . "</strong><br />";
		$entriessql = "SELECT * FROM entries WHERE cat_id = " . $validcat . " ORDER BY dateposted DESC;";
		$entriesres = mysql_query($entriessql);
		$numrows_entries = mysql_num_rows($entriesres);
			
		echo "<ul>";
		if($numrows_entries == 0) {
			echo "<li>No entries!</li>";
		}
		else {
			while($entriesrow = mysql_fetch_assoc($entriesres)) {
				echo "<li>" . date("D jS F Y g.iA", strtotime($entriesrow['dateposted'])) . " - <a href='viewentry.php?id=" . $entriesrow['id'] . "'>" . $entriesrow['subject'] . "</a></li>";
				if(isset($_SESSION['USERNAME'])) {
					if($_SESSION['USERID'] == $entriesrow['usr_id']) {
						echo "[<a href='updateentry.php?id=" . $entriesrow['id'] . "'>edit</a>]";
					}
				}
			}
		}
		echo "</ul>";
	}
	else {
		echo "<a href='viewcat.php?id=" . $row['id'] . "'>" . $row['cat'] . "</a><br />";
	}

}

/*if(isset($_SESSION['USERNAME']) == FALSE) {
	
	while($row = mysql_fetch_assoc($result)) {
		if($validcat == $row['id']) {
			echo "<strong>" . $row['cat'] . "</strong><br />";
			
			$entriessql = "SELECT * FROM entries WHERE cat_id = " . $validcat . " ORDER BY dateposted DESC;";
			$entriesres = mysql_query($entriessql);
			$numrows_entries = mysql_num_rows($entriesres);
			
			echo "<ul>";
			if($numrows_entries == 0) {
				echo "<li>No entries!</li>";
			}
			else {
				while($entriesrow = mysql_fetch_assoc($entriesres)) {
					echo "<li>" . date("D jS F Y g.iA", strtotime($entriesrow['dateposted'])) . " - <a href='viewentry.php?id=" . $entriesrow['id'] . "'>" . $entriesrow['subject'] . "</a></li>";
				}
			}
			echo "</ul>";
		}
		else {
			echo "<a href='viewcat.php?id=" . $row['id'] . "'>" . $row['cat'] . "</a><br />";
		}
	}
}
else {
	while($row = mysql_fetch_assoc($result)) {
		if($validcat == $row['id']) {
			echo "<strong>" . $row['cat'] . "</strong><br />";
			
			$entriessql = "SELECT * FROM entries WHERE cat_id = " . $validcat . " AND usr_id = " . $_SESSION['USERID'] . " ORDER BY dateposted DESC;";
			$entriesres = mysql_query($entriessql);
			$numrows_entries = mysql_num_rows($entriesres);
			
			echo "<ul>";
			if($numrows_entries == 0) {
				echo "<li>No entries!</li>";
			}
			else {
				while($entriesrow = mysql_fetch_assoc($entriesres)) {
					echo "<li>" . date("D jS F Y g.iA", strtotime($entriesrow['dateposted'])) . " - <a href='viewentry.php?id=" . $entriesrow['id'] . "'>" . $entriesrow['subject'] . "</a></li>";
					echo "[<a href='updateentry.php?id=" . $entriesrow['id'] . "'>edit</a>]";

				}
			}
			echo "</ul>";
		}
		else {
			echo "<a href='viewcat.php?id=" . $row['id'] . "'>" . $row['cat'] . "</a><br />";
		}
	}
}*/

require("footer.php")
?>


		
