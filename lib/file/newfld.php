<?php

require("lib/markdown.php");

$fld_name = "";
$fld_comment = "";
$fld_public = true;
if (isset($_POST['name']) && isset($_POST['comment'])) {
	$fld_public = isset($_POST['public']);
	$fld_name = esca($_POST['name']);
	$fld_comment = esca($_POST['comment']);
	$fld_comment_html = Markdown($fld_comment);
	if ($fld_name == "") {
		$error = "You must enter a name for your folder.";
	} else {
		sql("INSERT INTO folders(owner, name, comment, comment_html, public) ".
			"VALUES(" . $user['id'] . ", '" . escs($fld_name) . "', '" . escs($fld_comment) .
			"', '" . escs($fld_comment_html) . "', " . ($fld_public ? '1' : '0') . ")");
		header("Location: folder-file-" . mysql_insert_id());
		die();
	}
}

$title = "New folder";
$fields = array(
	array("label" => "Name : ", "name" => "name", "value" => $fld_name),
	array("label" => "Public ? ", "name" => "public", "type" => "checkbox", "checked" => $fld_public),
	array("label" => "Comment : ", "name" => "comment", "type" => "textarea", "value" => $fld_comment),
	);
$validate = "Create folder";

require("tpl/general/form.php");
