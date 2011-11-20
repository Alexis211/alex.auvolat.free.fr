<?php

$filters = array (
	"order" => array (
		"nbUsers" => "popularity",
		"name" => "name",
		"owner" => "author",
	),
	"way" => $ord_ways,
);
$fdefaults = array (
	"order" => "nbUsers",
	"way" => "DESC",
);

$lists = array();
$n = sql(
		"SELECT lists.id AS id, lists.name AS name, account.login AS owner, COUNT(list_study.id) AS nbUsers ".
		"FROM lists LEFT JOIN account ON lists.owner = account.id LEFT JOIN list_study ON list_study.list = lists.id ".
		"GROUP BY lists.id ORDER BY " . get_filter("order") . " " . get_filter("way")
	);
while ($nn = mysql_fetch_assoc($n)) $lists[] = $nn;

require("tpl/list/index.php");

