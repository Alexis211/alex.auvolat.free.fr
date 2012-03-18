<?php

require("lib/markdown.php");

assert_redir(count($args) == 3, 'image');
$fldid = intval($args[2]);

$fld = mysql_fetch_assoc(sql(
	"SELECT id, name, comment, public, owner ".
	"FROM img_folders WHERE id = $fldid"
	));
assert_error($fld && $fld['owner'] == $user['id'],
	"This folder does not exist, or you are not allowed to edit it.");

$fld_name = $fld['name'];
$fld_comment = $fld['comment'];
$fld_public = $fld['public'];
if (isset($_POST['name']) && isset($_POST['comment'])) {
	$fld_public = isset($_POST['public']);
	$fld_name = esca($_POST['name']);
	$fld_comment = esca($_POST['comment']);
	$fld_comment_html = Markdown($fld_comment);
	if ($fld_name == "") {
		$error = "You must enter a name for your folder.";
	} else {
		sql("UPDATE img_folders SET name = '" . escs($fld_name) . "', comment = '" . escs($fld_comment) .
			"', comment_html = '" . escs($fld_comment_html) . "', public = " . ($fld_public?'1':'0') .
			" WHERE id = $fldid");
		header("Location: folder-image-" . $fldid);
		die();
	}
	
}

$title = "Edit folder";
$fields = array(
	array("label" => "Name : ", "name" => "name", "value" => $fld_name),
	array("label" => "Public ? ", "name" => "public", "type" => "checkbox", "checked" => $fld_public),
	array("label" => "Comment : ", "name" => "comment", "type" => "textarea", "value" => $fld_comment),
	);
$validate = "Save";

require("tpl/general/form.php");

