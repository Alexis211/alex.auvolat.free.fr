<?php

require("lib/markdown.php");

assert_redir(count($args) == 3, 'deck');
$deckid = intval($args[2]);

$deck = mysql_fetch_assoc(sql(
	"SELECT decks.id AS id, decks.name AS name, decks.comment_md AS comment, decks.owner AS owner_id ".
	"FROM decks ".
	"WHERE decks.id = $deckid"));
assert_error($deck && $deck['owner_id'] == $user['id'],
	"This deck does not exist, or you are not allowed to edit it.");

$card_name = "";
$card_text = "";
if (isset($_POST['name']) && isset($_POST['text'])) {
	$card_name = esca($_POST['name']);
	$card_text = esca($_POST['text']);
	$card_text_html = Markdown($card_text);
	if ($card_name == "") {
		$error = "You must give your card a name.";
	} else if ($card_text == "") {
		$error = "You must put some text in your card.";
	} else if (mysql_fetch_assoc(sql("SELECT id FROM cards WHERE deck = $deckid AND name = '" . escs($card_name)."'"))) {
		$error = "You already have a card using that name.";
	} else {
		$n = mysql_fetch_assoc(sql("SELECT MAX(number) AS n FROM cards WHERE deck = $deckid"));
		$number = $n['n'] + 1;
		sql(
			"INSERT INTO cards(deck, number, name, text_md, text_html) ".
			"VALUES($deckid, $number, '" . escs($card_name) . "', '" . escs($card_text) . "', '" . escs($card_text_html). "')");
		header("Location: view-deck-$deckid");
		die();
	}
}

$title = "Add card to " . $deck['name'];
$message = "Your card will be added at the end of the deck. You can always move it afterwards.";
$fields = array(
	array("label" => "Name : ", "name" => "name", "value" => $card_name),
	array("label" => "Text : ", "name" => "text", "type" => "textarea", "value" => $card_text),
);
$validate = "Add card";

require("tpl/deck/ef.php");
