<?php

require("lib/markdown.php");

assert_redir(count($args) == 3, 'notes');
$noteid = intval($args[2]);

$note = mysql_fetch_assoc(sql(
	"SELECT na.id AS id, na.title AS title, na.text AS text, na.public AS public, na.owner AS owner, ".
	"nb.title AS parent_title, nb.id AS parent_id, account.login AS ownername FROM notes na ".
	"LEFT JOIN notes nb ON na.parent = nb.id LEFT JOIN account ON account.id = na.owner ".
	"WHERE na.id = $noteid"
));
assert_error($note && $note['owner'] == $user['id'],
	"This note does not exist, or you are not allowed to edit it.");

$note_title = $note['title'];
$note_text = $note['text'];
$note_public = $note['public'];
if (isset($_POST['title']) && isset($_POST['text'])) {
	$note_title = esca($_POST['title']);
	$note_text = esca($_POST['text']);
	$note_html = Markdown($note_text);
	$note_public = isset($_POST['public']);
	if ($note_title == "") {
		$error = "You must enter a title for your note";
	} else {
		if (isset($_POST['preview']) && $_POST['preview'] == "Preview") {
			$preview = $note_html;
			$message = "Your preview is below the edit form.";
		} else {
			sql("UPDATE notes SET title = '" . escs($note_title) . "', text = '" . escs($note_text) .
				"', text_html = '" . escs($note_html) . "', public = " . ($note_public?'1':'0') .
				" WHERE id = $noteid");
			header("Location: view-notes-" . $noteid);
			die();
		}
	}
}

$title = "Edit : " . $note['title'];
$fields = array(
	array("label" => "Title : ", "name" => "title", "value" => $note_title),
	array("label" => "Public ? ", "name" => "public", "type" => "checkbox", "checked" => $note_public),
	array("label" => "Text : ", "name" => "text", "type" => "textarea", "value" => $note_text),
	array("label" => "Preview : ", "name" => "preview", "type" => "submit", "value" => "Preview"),
	);
$validate = "Edit note";

require("tpl/notes/edit.php");
