<?php

require("tpl/general/top.php");

function f($n) {
	global $note;
	return $n['title'] . ' - <a class="tool_link" href="move-notes-' . $note['id'] . '-' . $n['id'] . '">move here</a>';
}

require("tpl/general/inc_tree.php");
tree($notes_tree, @f);
echo '<a class="tool_link" href="move-notes-'.$note['id'].'-0">move to root</a>';

$can_new = false;
require("tpl/notes/inc_relativestree.php");
require("tpl/general/bottom.php");
