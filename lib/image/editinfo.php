<?php

require("lib/markdown.php");

require("lib/conf/image.php");

$title = "Rename an image";

if (count($args) < 3) header("location: index.php");
$id = intval($args[2]);

$info = mysql_fetch_assoc(sql(
	"SELECT images.owner AS owner, images.id AS id, images.name AS name, images.comment AS comment,
		img_folders.id AS folder_id, img_folders.name AS folder_name
		FROM images LEFT JOIN img_folders ON images.folder = img_folders.id WHERE images.id = $id"
));

assert_error($info["owner"] == $user["id"], "You cannot rename this image.");

$name = $info['name'];
$comment = $info['comment'];
$folder = $info['folder_id'];
if (isset($_POST['name']) && isset($_POST['comment']) && isset($_POST['folder'])) {
	$name = esca($_POST['name']);
	$comment = esca($_POST['comment']);
	$comment_html = Markdown($comment);
	$folder = intval($_POST['folder']);
	if ($name == "") {
		$error = "You must give a non-empty name to this image. Please.";
	} else {
		sql("UPDATE images SET name = '" . escs($name) . "', comment='" . escs($comment). "',
				comment_html = '" . escs($comment_html) . "', folder = $folder WHERE id = $id");
		header("Location: image");
		die();
	}
}

$folders = array(0 => "[no folder]");
$r = sql("SELECT id, name FROM img_folders WHERE owner = " . $user['id'] . " ORDER BY name ASC");
while ($n = mysql_fetch_array($r))
	$folders[$n['id']] = $n['name'];

$title = "Edit image info : " . $info['name'];
$fields = array(
	array("label" => "Name : ", "name" => "name", "value" => $name),
	array("label" => "Folder : ", "type" => "select", "name" => "folder", "choices" => $folders, "value" => $folder),
	array("label" => "Comment : ", "name" => "comment", "value" => $comment, "type" => "textarea"),
);
$validate = "Save";

require("tpl/general/form.php");
