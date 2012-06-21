<?php

require("lib/markdown.php");

require("lib/conf/file.php");

$title = "Rename a file";

if (count($args) < 3) header("location: index.php");
$id = intval($args[2]);

$info = mysql_fetch_assoc(sql(
	"SELECT files.owner AS owner, files.id AS id, files.name AS name, files.comment AS comment,
		folders.id AS folder_id, folders.name AS folder_name
		FROM files LEFT JOIN folders ON files.folder = folders.id WHERE files.id = $id"
));

assert_error($info["owner"] == $user["id"], "You cannot rename this file.");

$name = $info['name'];
$comment = $info['comment'];
$folder = $info['folder_id'];
if (isset($_POST['name']) && isset($_POST['comment']) && isset($_POST['folder'])) {
	$name = esca($_POST['name']);
	$comment = esca($_POST['comment']);
	$comment_html = Markdown($comment);
	$folder = intval($_POST['folder']);
	if ($name == "") {
		$error = "You must give a non-empty name to this file. Please.";
	} else {
		sql("UPDATE files SET name = '" . escs($name) . "', comment='" . escs($comment). "',
				comment_html = '" . escs($comment_html) . "', folder = $folder WHERE id = $id");
		if ($folder == 0) {
			header("Location: file");
		} else {
			header("Location: folder-file-$folder");
		}
		die();
	}
}

$folders = array(0 => "[no folder]");
$r = sql("SELECT id, name FROM folders WHERE owner = " . $user['id'] . " ORDER BY name ASC");
while ($n = mysql_fetch_array($r))
	$folders[$n['id']] = $n['name'];

$title = "Edit file info : " . $info['name'];
$fields = array(
	array("label" => "File name : ", "name" => "name", "value" => $name),
	array("label" => "Folder : ", "type" => "select", "name" => "folder", "choices" => $folders, "value" => $folder),
	array("label" => "Comment : ", "name" => "comment", "value" => $comment, "type" => "textarea"),
);
$validate = "Save";

require("tpl/general/form.php");
