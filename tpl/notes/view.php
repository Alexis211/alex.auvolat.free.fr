<?php
$title = $note["title"];
require("tpl/general/top.php");

$t = array();
if ($note['parent_id'] != 0) {
	$t[] = 'parent : <a href="view-notes-'. $note['parent_id'] . '">' . $note['parent_title'] . '</a>';
}
if ($can_edit) $t[] = '<a href="edit-notes-' . $note['id'] . '">edit</a>';
$t[] = '<a href="source-notes-' . $note['id'] . '">view source</a>';
if ($can_move) $t[] = '<a href="move-notes-' . $note['id'] . '">move</a>';
if ($can_delete) $t[] = '<a href="delete-notes-' . $note['id'] . '">delete</a>';
echo '<div class="small_right">' . implode(' | ', $t) . '</div>';
echo $note['html'];

require("tpl/notes/inc_relativestree.php");

require("tpl/general/bottom.php");
