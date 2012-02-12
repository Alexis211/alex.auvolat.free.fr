<?php

require("lib/conf/image.php");

$filters = array (
	"order" => array (
			"name" => "title",
			"upl_date" => "date uploaded",
		),
	"way" => $ord_ways,
);
$fdefaults = array (
	"order" => "name",
	"way" => "ASC",
);

$title = "Image upload";

$images = array();
$files = sql("SELECT * FROM images WHERE owner = " . $user['id'] .
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

$can_delete = ($user['priv'] >= $apps['image']['delete'] && $user['id'] != 0);
$can_rename = ($user['priv'] >= $apps['image']['rename'] && $user['id'] != 0);

require("tpl/image/index.php");
