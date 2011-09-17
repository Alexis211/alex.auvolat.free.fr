<?php

$users = array();
$n = sql("SELECT account.id AS id, login AS name, COUNT(notes.id) AS nbNotes FROM account ".
	"LEFT JOIN notes ON notes.owner = account.id ".
	"WHERE notes.public != 0 AND notes.id != 0 ".
	"GROUP BY account.id ORDER BY nbNotes DESC");
while ($nn = mysql_fetch_assoc($n)) $users[] = $nn;
require("tpl/notes/index.php");
