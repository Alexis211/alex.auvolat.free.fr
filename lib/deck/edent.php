<?php

require("lib/markdown.php");

assert_redir(count($args) == 3, 'deck');
$cardid = intval($args[2]);

$card = mysql_fetch_assoc(sql(
	"SELECT decks.id AS deckid, decks.owner AS deckowner, decks.name AS deckname, cards.name AS name, cards.text_md AS text ".
	"FROM cards LEFT JOIN decks ON decks.id = cards.deck ".
	"WHERE cards.id = $cardid"));
assert_error($card && $card["deckowner"] == $user['id'],
	"This card does not exist, or you are not allowed to edit it.");
$deck = array("id" => $card['deckid'], 'name' => $card['deckname']);

$card_name = $card['name'];
$card_text = $card['text'];
if (isset($_POST['name']) && isset($_POST['text'])) {
	$card_name = esca($_POST['name']);
	$card_text = esca($_POST['text']);
	$card_text_html = Markdown($card_text);
	if ($card_name == "") {
		$error = "You must give your card a name.";
	} else if ($card_text == "") {
		$error = "You must put some text in your card.";
	} else if (mysql_fetch_assoc(sql("SELECT id FROM cards WHERE deck = " . $deck['id'] . " AND name = '" . escs($card_name)."' AND id != $cardid"))) {
		$error = "You already have a card using that name.";
	} else {
		sql("UPDATE cards SET name = '" . escs($card_name) . "', text_md = '" . escs($card_text) . "', text_html = '" . escs($card_text_html) . "'" .
		 " WHERE id = $cardid");
		header("Location: view-deck-" . $deck['id']);
		die();
	}
}

$title = "Edit card in " . $deck['name'];
$fields = array(
	array("label" => "Name : ", "name" => "name", "value" => $card_name),
	array("label" => "Text : ", "name" => "text", "type" => "textarea", "value" => $card_text),
);
$validate = "Edit card";

require("tpl/deck/ef.php");

