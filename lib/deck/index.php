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

$decks = array();
$n = sql(
		"SELECT decks.id AS id, decks.name AS name, account.login AS owner, COUNT(deck_study.id) AS nbUsers ".
		"FROM decks LEFT JOIN account ON decks.owner = account.id LEFT JOIN deck_study ON deck_study.deck = decks.id ".
		"GROUP BY decks.id ORDER BY " . get_filter("order") . " " . get_filter("way")
	);
while ($nn = mysql_fetch_assoc($n)) $decks[] = $nn;

require("tpl/deck/index.php");

