<?php

assert_redir(count($args) == 3, 'deck');
$deckid = intval($args[2]);

$deck = mysql_fetch_assoc(sql(
	"SELECT decks.id AS id, decks.name AS name, decks.comment_html AS comment, account.login AS owner, account.id AS owner_id ".
	"FROM decks LEFT JOIN account ON account.id = decks.owner ".
	"WHERE decks.id = $deckid"));
assert_error($deck, "This deck does not exist.");

$filters = array (
	"order" => array (
		"name" => "card name",
		"number" => "card number",
	),
	"way" => $ord_ways,
);
$fdefaults = array (
	"order" => "number",
	"way" => "ASC",
);

$cards = array();
$n = sql(
		"SELECT id, number, name, text_html AS text FROM cards WHERE deck = $deckid ".
		"ORDER BY " . get_filter("order") . " " . get_filter("way")
	);
while ($nn = mysql_fetch_assoc($n)) $cards[] = $nn;

$can_edit = false;
if ($deck["owner_id"] == $user['id']) $can_edit = true;

require("tpl/deck/view.php");
