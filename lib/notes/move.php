<?php

assert_redir(count($args) >= 3, 'notes');
$noteid = intval($args[2]);

$note = mysql_fetch_assoc(sql(
	"SELECT na.id AS id, na.title AS title, na.text AS text, na.public AS public, na.owner AS owner, ".
	"nb.title AS parent_title, nb.id AS parent_id, account.login AS ownername FROM notes na ".
	"LEFT JOIN notes nb ON na.parent = nb.id LEFT JOIN account ON account.id = na.owner ".
	"WHERE na.id = $noteid"
));
assert_error($note && $note['owner'] == $user['id'],
	"This note does not exist, or you are not allowed to move it.");

if (count($args) == 4) {
	$newparent = intval($args[3]);
	// SHOULD CHECK FOR TREE CONSISTENCY, SKIP FOR NOW.
	if ($newparent != 0)  {
		$p = mysql_fetch_assoc(sql("SELECT id, owner FROM notes WHERE id = $newparent"));
	}
	if ($newparent != 0 && !$p) {
		$error = "Selected parent does not exist.";
	} else if ($newparent != 0 && $p['owner'] != $user['id']) {
		$error = "Selected parent is not belong to you.";
	} else {
		sql("UPDATE notes SET parent = $newparent WHERE id = $noteid");
		header("Location: view-notes-$noteid");
		die();
	}
}

$notes_tree = array();
$n = sql("SELECT id, parent, title FROM notes ".
	"WHERE owner =  " . $user['id'] . " AND id != $noteid AND parent != $noteid ORDER BY title ASC");
while ($nn = mysql_fetch_assoc($n)) {
	if (isset($notes_tree[$nn['parent']])) {
		$notes_tree[$nn['parent']][] = $nn;
	} else {
		$notes_tree[$nn['parent']] = array($nn);
	}
}

$title = "Move note : " . $note["title"];
require("tpl/notes/move.php");
