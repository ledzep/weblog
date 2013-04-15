<?php

require("header.php");

$sql = "SELECT entries.*, categories.cat FROM entries, categories
	WHERE entries.cat_id = categories.id
	ORDER BY dateposted DESC
	LIMIT 1;";
$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);
echo "<br />";
echo "<h3><a href='viewentry.php?id=" . $row['id'] . "'>" . $row['subject'] . "</a></h3><br />";
echo "<i>In <a href='viewcat.php?id=" . $row['cat_id'] . "'>" . $row['cat'] . "</a> - Posted on " . date("D jS F Y g.iA", strtotime($row['dateposted'])) . "</i>";
/*if(isset($_SESSION['USERNAME']) == TRUE) {
	echo " [<a href='updateentry.php?id=" . $row['id'] . "'>edit</a>]";
}*/
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

echo "<p>";
$comsql = "SELECT name FROM comments WHERE blog_id = " . $row['id'] . " ORDER BY dateposted;";
$comresult = mysql_query($comsql);
$numrows_comm = mysql_num_rows($comresult);

if ($numrows_comm == 0) {
	echo "<p>No comments.</p>";
}
else {
	echo "[<strong>" . $numrows_comm . "</strong>] comments : ";
	$i = 1;
	while ($commrow = mysql_fetch_assoc($comresult)) {
		echo "<a href='viewentry.php?id=" . $row['id'] . "#comment" . $i . "'>" . $commrow['name'] . "</a> ";
		$i++;
	}
}
echo "</p>";
$prevsql = "SELECT entries.*, categories.cat FROM entries, categories
	WHERE entries.cat_id = categories.id
	ORDER BY dateposted DESC
	LIMIT 1, 5;";
$prevresult = mysql_query($prevsql);
$numrows_prev = mysql_num_rows($prevresult);

if ($numrows_prev == 0) {
	echo "<p>No previous entries.</p>";
}
else {
	echo "<ul>";
	while($prevrow = mysql_fetch_assoc($prevresult)) {
		echo "<li><a href='viewentry.php?id=" . $prevrow['id'] . "'>" . $prevrow['subject'] . "</a></li>";
	}
}

echo "</ul>";

require("footer.php");

?>
