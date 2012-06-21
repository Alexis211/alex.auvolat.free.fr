<?php

require("lib/conf/file.php");

$filters = array (
	"order" => array (
			"name" => "title",
			"upl_date" => "date uploaded",
			//"folder_name" => "folder",
		),
	"way" => $ord_ways,
);
$fdefaults = array (
	"order" => "upl_date",
	"way" => "DESC",
);

$title = "File upload";

$files = array();
$fileq = sql("SELECT files.id AS id, files.name AS name, files.extension AS extension, files.upl_date AS upl_date, ".
				"files.comment_html AS comment_html, folders.id AS folder_id, folders.name AS folder_name ".
				" FROM files LEFT JOIN folders ON folders.id = files.folder ".
				"WHERE files.folder = 0 AND files.owner = " . $user['id'] .
	" ORDER BY " . get_filter('order') . " " . get_filter('way'));
while ($img = mysql_fetch_assoc($fileq)) $files[] = $img;

if ($user['priv'] < $apps['file']['upload']) {
	$error = "You don't have the rights to upload files.";
	$can_upload = false;
} else {
	$can_upload = true;
}

$folders = array();
$r = sql("SELECT id, name FROM folders WHERE owner = " . $user['id'] . " ORDER BY name ASC");
while ($f = mysql_fetch_assoc($r)) {
	$folders[] = $f;
}

$can_delete = ($user['priv'] >= $apps['file']['delete'] && $user['id'] != 0);
$can_rename = ($user['priv'] >= $apps['file']['editinfo'] && $user['id'] != 0);

require("tpl/file/index.php");
