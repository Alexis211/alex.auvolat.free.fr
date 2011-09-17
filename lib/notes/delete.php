<?php

assert_redir(count($args) >= 3, 'notes');
$noteid = intval($args[2]);

$note = mysql_fetch_assoc(sql("SELECT owner FROM notes WHERE id = $noteid"));
assert_error($note && $note['owner'] == $user['id'],
	"This note does not exist, or you are not allowed to delete it.");

token_validate("Do you really want to delete this note ? All children notes will become children of the root note.", "view-notes-$noteid");
sql("DELETE FROM notes WHERE id = $noteid");
sql("UPDATE notes SET parent = 0 WHERE parent = $noteid");
header("Location: user-notes-" . $user['id']);
