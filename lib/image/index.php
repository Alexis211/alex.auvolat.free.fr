<?php

require("lib/conf/image.php");

$filters = array (
	"order" => array (
			"name" => "title",
			"upl_date" => "date uploaded",
			"folder_name" => "folder",
		),
	"way" => $ord_ways,
);
$fdefaults = array (
	"order" => "name",
	"way" => "ASC",
);

$title = "Image upload";

$images = array();
$files = sql("SELECT images.id AS id, images.name AS name, images.extension AS extension, images.upl_date AS upl_date, ".
				"images.comment_html AS comment_html, img_folders.id AS folder_id, img_folders.name AS folder_name ".
				" FROM images LEFT JOIN img_folders ON img_folders.id = images.folder ".
				"WHERE images.owner = " . $user['id'] .
	" ORDER BY " . get_filter('order') . " " . get_filter('way'));
while ($img = mysql_fetch_assoc($files)) $images[] = $img;

/*if (count($images) >= $quota && $user['priv'] < $min_priv_for_no_quota) {
	$error = "You have already exceeded your quota of $quota uploadable images.";
	$can_upload = false;
} else */

if ($user['priv'] < $apps['image']['upload']) {
	$error = "You don't have the rights to upload images.";
	$can_upload = false;
} else {
	$can_upload = true;
}

$folders = array();
$r = sql("SELECT id, name FROM img_folders WHERE owner = " . $user['id'] . " ORDER BY name ASC");
while ($f = mysql_fetch_assoc($r)) {
	$folders[] = $f;
}

$can_delete = ($user['priv'] >= $apps['image']['delete'] && $user['id'] != 0);
$can_rename = ($user['priv'] >= $apps['image']['editinfo'] && $user['id'] != 0);

require("tpl/image/index.php");
