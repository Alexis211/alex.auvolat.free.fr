<?php

require("lib/markdown.php");

$list_name = "";
$list_comment = "";
if (isset($_POST["name"]) && isset($_POST['comment'])) {
	$list_name = esca($_POST['name']);
	$list_comment = esca($_POST['comment']);
	$list_comment_html = Markdown($list_comment);
	if ($list_name == "") {
		$error = "You must enter a name for your list.";
	} else if (mysql_fetch_assoc(sql("SELECT id FROM lists WHERE owner = " . $user['id'] . " AND name = '" . escs($list_name) . "'"))) {
		$error = "You already have a list with that title.";
	} else if ($list_comment == "") {
		$error = "Please enter a comment on your list.";
	} else {
		sql("INSERT INTO lists(owner, name, comment_md, comment_html) ".
			"VALUES(" . $user['id'] . ", '" . escs($list_name) . "', '" . escs($list_comment) . "', '" . escs($list_comment_html) . "')");
		header("Location: view-list-" . mysql_insert_id());
		die();
	}
}

$title = "Create list";
$fields = array(
	array("label" => "Name : ", "name" => "name", "value" => $list_name),
	array("label" => "Comment : ", "name" => "comment", "type" => "textarea", "value" => $list_comment),
	);
$validate = "Create list";

require("tpl/list/new.php");

