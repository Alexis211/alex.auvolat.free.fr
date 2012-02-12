<?php

$filters = array (
	"order" => array (
			"name" => "username",
			"reg_date" => "date registered",
			"nbNotes" => "number of notes",
		),
	"way" => $ord_ways,
);
$fdefaults = array (
	"order" => "name",
	"way" => "ASC",
);

$users = array();
$n = sql("SELECT account.id AS id, login AS name, nc.count AS nbNotes, pc.count AS nbPosts ".
	"FROM account ".
	"LEFT JOIN (SELECT notes.owner AS owner, COUNT(notes.id) AS count FROM notes WHERE notes.public != 0 GROUP BY notes.owner) nc ON nc.owner = account.id ".
	"LEFT JOIN (SELECT blog_posts.owner AS owner, COUNT(blog_posts.id) AS count FROM blog_posts GROUP BY blog_posts.owner) pc ON pc.owner = account.id ".
	"ORDER BY " . get_filter("order") . " " . get_filter("way"));
while ($nn = mysql_fetch_assoc($n)) $users[] = $nn;
require("tpl/account/list.php");
