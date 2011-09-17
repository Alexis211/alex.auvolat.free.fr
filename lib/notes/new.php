<?php

require("lib/markdown.php");

assert_redir(count($args) == 3, 'notes');
$parentid = intval($args[2]);

if ($parentid != 0) {
	$parent = mysql_fetch_assoc(sql(
		"SELECT na.id AS id, na.title AS title, na.text_html AS html, na.public AS public, na.owner AS owner, ".
		"nb.title AS parent_title, nb.id AS parent_id, account.login AS ownername FROM notes na ".
		"LEFT JOIN notes nb ON na.parent = nb.id LEFT JOIN account ON account.id = na.owner ".
		"WHERE na.id = $parentid"
	));
	assert_error($parent && $parent['owner'] == $user['id'],
		"The selected parent does not exist, or you cannot create children for it.");
}

$note_title = "";
$note_text = "";
$note_public = (isset($parent) ? $parent['public'] : true);
if (isset($_POST['title']) && isset($_POST['text'])) {
	$note_title = esca($_POST['title']);
	$note_text = esca($_POST['text']);
	$note_html = Markdown($note_text);
	$note_public = isset($_POST['public']);
	if ($note_title == "") {
		$error = "You must enter a title for your note";
	} else {
		sql("INSERT INTO notes(owner, parent, title, text, text_html, public) ".
			"VALUES(" . $user['id'] . ", $parentid, '" . escs($note_title) . "', '" . 
				escs($note_text) . "', '" . escs($note_html) . "', ". ($note_public?'1':'0') . ")");
		header("Location: view-notes-" . mysql_insert_id());
		die();
	}
}


$title = "New note";
$fields = array(
	array("label" => "Title : ", "name" => "title", "value" => $note_title),
	array("label" => "Public ? ", "name" => "public", "type" => "checkbox", "checked" => $note_public),
	array("label" => "Text : ", "name" => "text", "type" => "textarea", "value" => $note_text),
	);
$validate = "Create note";

require("tpl/notes/new.php");
