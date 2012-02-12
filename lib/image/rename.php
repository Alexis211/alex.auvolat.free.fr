<?php

require("lib/conf/image.php");

$title = "Rename an image";

if (count($args) < 3) header("location: index.php");
$id = intval($args[2]);

$info = mysql_fetch_assoc(sql("SELECT * FROM images WHERE id = $id"));

assert_error($info["owner"] == $user["id"], "You cannot rename this image.");

$name = $info['name'];
if (isset($_POST['name'])) {
	$name = esca($_POST['name']);
	if ($name == "") {
		$error = "You must give a non-empty name to this image. Please.";
	} else {
		sql("UPDATE images SET name = '" . escs($name) . "' WHERE id = $id");
		header("Location: image");
		die();
	}
}

$title = "Rename : " . $info['name'];
$fields = array(
	array("label" => "New name : ", "name" => "name", "value" => $name),
);
$validate = "Rename";

require("tpl/general/form.php");
