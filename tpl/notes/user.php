<?php
$title = $note_owner['name'] . "'s notebook";
require("tpl/general/top.php");

function f($n) {
	return '<a href="view-notes-' . $n['id'] . '">' . $n['title'] . '</a>';
}

require("tpl/general/inc_tree.php");
tree($notes_tree, @f);
if ($note_owner['id'] == $user['id']) {
	echo '<a class="tool_link" href="new-notes-0">create new note</a>';
}

echo '</div><div class="contents-left">';
echo '<h1>Other users</h1>';
echo "<ul>";
foreach($users as $u) {
	if ($u['id'] == $userid) {
		echo '<li>' . $u['name'] . ' (' . $u['nbNotes'] . ' notes)</li>';
	} else {
		echo '<li><a href="user-notes-' . $u['id'] . '">' . $u['name'] . '</a> (' . $u['nbNotes'] . ' notes)</li>';
	}
}
echo "</ul>";

require("tpl/general/bottom.php");
