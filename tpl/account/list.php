<?php
$title = "People";
require("tpl/general/top.php");

echo '<div class="ordering_links">' . filters_html_full() . '</div>';

echo "<table>";
echo "<tr><th>Username</th><th>Notebook</th><th>Blog</th></tr>";
foreach($users as $u) {
	echo '<tr><td>' . $u['name'] . '</td>';
	if ($u['nbNotes'] > 0) {
		echo '<td><a href="user-notes-' . $u['id'] . '">' . $u['nbNotes'] . ' notes</a></td>';
	} else {
		echo '<td>no notes</td>';
	}
	if ($u['nbPosts'] > 0) {
		echo '<td><a href="index-blog-author-'.$u['id'].'">' . $u['nbPosts'] . ' posts</a></td>';
	} else {
		echo '<td>no posts</td>';
	}
	echo '</tr>';
}
echo "</table>";

require("tpl/general/bottom.php");
