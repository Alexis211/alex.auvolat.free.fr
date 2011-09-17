<?php

require("lib/markdown.php");

assert_redir(count($args) >= 3, 'deck');
$cardid = intval($args[2]);

$card = mysql_fetch_assoc(sql(
	"SELECT decks.id AS deckid, decks.owner AS deckowner, decks.name AS deckname, cards.name AS name, cards.text_md AS text, cards.number AS number ".
	"FROM cards LEFT JOIN decks ON decks.id = cards.deck ".
	"WHERE cards.id = $cardid"));
assert_error($card && $card["deckowner"] == $user['id'],
	"This card does not exist, or you are not allowed to edit it.");

token_validate("Do you really want to delete this card ?", "view-deck-". $card['deckid']);
sql("DELETE FROM cards WHERE id = $cardid");
sql("UPDATE cards SET number = number - 1 WHERE number > " . $card['number'] . " AND deck = " . $card['deckid']);
header("Location: view-deck-" . $card['deckid']);
