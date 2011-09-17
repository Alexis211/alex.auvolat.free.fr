<?php
$title = "User's notebooks";
require("tpl/general/top.php");

echo "<ul>";
foreach($users as $u) {
	echo '<li><a href="user-notes-' . $u['id'] . '">' . $u['name'] . '</a> (' . $u['nbNotes'] . ' notes)</li>';
}
echo "</ul>";

require("tpl/general/bottom.php");
