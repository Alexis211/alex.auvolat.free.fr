<?php

require("lib/markdown.php");

$deck_name = "";
$deck_comment = "";
if (isset($_POST["name"]) && isset($_POST['comment'])) {
	$deck_name = esca($_POST['name']);
	$deck_comment = esca($_POST['comment']);
	$deck_comment_html = Markdown($deck_comment);
	if ($deck_name == "") {
		$error = "You must enter a name for your deck.";
	} else if (mysql_fetch_assoc(sql("SELECT id FROM decks WHERE owner = " . $user['id'] . " AND name = '" . escs($deck_name) . "'"))) {
		$error = "You already have a deck with that title.";
	} else if ($deck_comment == "") {
		$error = "Please enter a comment on your deck.";
	} else {
		sql("INSERT INTO decks(owner, name, comment_md, comment_html) ".
			"VALUES(" . $user['id'] . ", '" . escs($deck_name) . "', '" . escs($deck_comment) . "', '" . escs($deck_comment_html) . "')");
		header("Location: view-deck-" . mysql_insert_id());
		die();
	}
}

$title = "Create deck";
$fields = array(
	array("label" => "Name : ", "name" => "name", "value" => $deck_name),
	array("label" => "Comment : ", "name" => "comment", "type" => "textarea", "value" => $deck_comment),
	);
$validate = "Create deck";

require("tpl/deck/new.php");
