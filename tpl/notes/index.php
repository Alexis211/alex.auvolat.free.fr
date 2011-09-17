<?php
$title = "User's notebooks";
require("tpl/general/top.php");

echo '<div class="ordering_links">' . filters_html_full() . '</div>';

echo "<ul>";
foreach($users as $u) {
	echo '<li><a href="user-notes-' . $u['id'] . '">' . $u['name'] . '</a> (' . $u['nbNotes'] . ' notes)</li>';
}
echo "</ul>";

require("tpl/general/bottom.php");
