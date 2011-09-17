<?php

$filters = array (
	"order" => array (
			"nbNotes" => "number of notes",
			"name" => "username",
		),
	"way" => $ord_ways,
);
$fdefaults = array (
	"order" => "nbNotes",
	"way" => "DESC",
);

$users = array();
$n = sql("SELECT account.id AS id, login AS name, COUNT(notes.id) AS nbNotes FROM account ".
	"LEFT JOIN notes ON notes.owner = account.id ".
	"WHERE notes.public != 0 AND notes.id != 0 ".
	"GROUP BY account.id ORDER BY " . get_filter("order") . " " . get_filter("way"));
while ($nn = mysql_fetch_assoc($n)) $users[] = $nn;
require("tpl/notes/index.php");
