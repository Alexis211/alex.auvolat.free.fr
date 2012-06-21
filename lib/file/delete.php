<?php

require("lib/conf/file.php");

$title = "Delete a file";

if (count($args) < 3) header("location: index.php");
$id = intval($args[2]);

$info = mysql_fetch_assoc(sql("SELECT * FROM files WHERE id = $id"));

if ($info["owner"] == $user["id"]) {
	token_validate("Do you really want to delete this file ?", "file");
	if (has_mini($info["extension"])) unlink($savedir . $id . "-min." . $info["extension"]);
	unlink($savedir . $id . "." . $info["extension"]);
	sql("DELETE FROM files WHERE id = $id");
	header("location: file");
} else {
	$error = "You cannot delete this file.";
}
require("tpl/general/empty.php");
