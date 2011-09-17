<?php

require("lib/conf/image.php");

$title = "Delete an image";

if (count($args) < 3) header("location: index.php");
$id = intval($args[2]);

$info = mysql_fetch_assoc(sql("SELECT * FROM images WHERE id = $id"));

if ($info["owner"] == $user["id"]) {
	token_validate("Do you really want to delete this image ?", "image");
	unlink($savedir . $id . "-min." . $info["extension"]);
	unlink($savedir . $id . "." . $info["extension"]);
	sql("DELETE FROM images WHERE id = $id");
	header("location: image");
} else {
	$error = "You cannot delete this image.";
}
require("tpl/general/empty.php");
