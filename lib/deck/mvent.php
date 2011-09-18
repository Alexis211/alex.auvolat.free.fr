<?php

require("lib/markdown.php");

assert_redir(count($args) == 4, 'deck');
$cardid = intval($args[2]);
$pos = intval($args[3]);

$card = mysql_fetch_assoc(sql(
	"SELECT decks.id AS deckid, decks.owner AS deckowner, decks.name AS deckname, cards.name AS name, cards.text_md AS text, cards.number AS number ".
	"FROM cards LEFT JOIN decks ON decks.id = cards.deck ".
	"WHERE cards.id = $cardid"));
assert_error($card && $card["deckowner"] == $user['id'],
	"This card does not exist, or you are not allowed to edit it.");
$deck = array("id" => $card['deckid'], 'name' => $card['deckname']);
$deckid = $card['deckid'];

$mn = mysql_fetch_assoc(sql("SELECT COUNT(*) AS c FROM cards WHERE deck = $deckid"));
$mn = $mn['c'];
if ($pos > $mn) {
	$error = "That number is too big. You don't even have that much cards in your deck.";
} else if ($pos < 1) {
	$error = "A position is at least one...";
} else {
	sql("UPDATE cards SET number = 0 WHERE id = $cardid");
	sql("UPDATE cards SET number = number - 1 WHERE number > " . $card['number']);
	sql("UPDATE cards SET number = number + 1 WHERE number >= $pos");
	sql("UPDATE cards SET number = $pos WHERE id = $cardid");
	sql("UPDATE deck_study SET need_check = 1 WHERE deck = $deckid");
	header("Location: view-deck-$deckid");
}

require("tpl/deck/ef.php");
