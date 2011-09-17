<?php

require("lib/markdown.php");

assert_redir(count($args) == 3, 'deck');
$deckid = intval($args[2]);

$deck = mysql_fetch_assoc(sql(
	"SELECT decks.id AS id, decks.name AS name, decks.comment_md AS comment, account.id AS owner_id ".
	"FROM decks LEFT JOIN account ON account.id = decks.owner ".
	"WHERE decks.id = $deckid"));
assert_error($deck && $deck['owner_id'] == $user['id'],
	"This deck does not exist, or you are not allowed to edit it.");

$deck_name = $deck['name'];
$deck_comment = $deck['comment'];
if (isset($_POST['name']) && isset($_POST['comment'])) {
	$deck_name = esca($_POST['name']);
	$deck_comment = esca($_POST['comment']);
	$deck_comment_html = Markdown($deck_comment);
	if ($deck_name == "") {
		$error = "You must enter a name for your deck.";
	} else if (mysql_fetch_assoc(sql("SELECT id FROM decks WHERE owner = " . $user['id'] . " AND name = '" . escs($deck_name) . "' AND id != $deckid"))) {
		$error = "You already have a deck with that title.";
	} else if ($deck_comment == "") {
		$error = "Please enter a comment on your deck.";
	} else {
		sql("UPDATE decks SET name = '" . escs($deck_name) . "', comment_md = '" . escs($deck_comment) . 
		"', comment_html = '" . escs($deck_comment_html) . "' WHERE id = $deckid");
		header("Location: view-deck-" . $deckid);
		die();
	}
}

$title = "Edit : " . $deck['name'];
$fields = array(
	array("label" => "Name : ", "name" => "name", "value" => $deck_name),
	array("label" => "Comment : ", "name" => "comment", "type" => "textarea", "value" => $deck_comment),
);
$validate = "Edit deck";

require("tpl/deck/ef.php");
