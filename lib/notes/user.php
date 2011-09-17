<?php

assert_redir(count($args) == 3, 'notes');
$userid = intval($args[2]);

if ($userid == $user['id']) {
	$note_owner = $user;
} else {
	$note_owner = mysql_fetch_assoc(sql("SELECT login AS name, id FROM account WHERE id = $userid"));
	assert_error($note_owner, "That user id does not exist.", "no such user");
}

$users = array();
$n = sql("SELECT account.id AS id, login AS name, COUNT(notes.id) AS nbNotes FROM account ".
	"LEFT JOIN notes ON notes.owner = account.id ".
	"WHERE notes.public != 0 AND notes.id != 0 ".
	"GROUP BY account.id ORDER BY nbNotes DESC");
while ($nn = mysql_fetch_assoc($n)) $users[] = $nn;

$notes_tree = array();
$n = sql("SELECT id, parent, title FROM notes ".
	"WHERE owner = $userid ".
	($userid == $user['id'] ? "" : "AND public != 0 ").
	"ORDER BY title ASC");
while ($nn = mysql_fetch_assoc($n)) {
	if (isset($notes_tree[$nn['parent']])) {
		$notes_tree[$nn['parent']][] = $nn;
	} else {
		$notes_tree[$nn['parent']] = array($nn);
	}
}

require("tpl/notes/user.php");
