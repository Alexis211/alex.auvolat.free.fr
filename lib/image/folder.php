<?php

require("lib/conf/image.php");

assert_redir(count($args) == 3, 'image');
$fldid = intval($args[2]);

$fld = mysql_fetch_assoc(sql(
	"SELECT img_folders.id AS id, img_folders.name AS name, img_folders.comment_html AS comment_html, ".
	"img_folders.public AS public, account.id AS owner, account.login AS ownername FROM img_folders ".
	"LEFT JOIN account ON account.id = img_folders.owner ".
	"WHERE img_folders.id = $fldid"
));
assert_error($fld && ($fld['public'] != 0 || $fld['owner'] == $user['id']),
	"This folder does not exist, or you are not allowed to see it.");

$can_edit = ($user['priv'] >= $apps['image']['editfld'] && $user['id'] == $fld['owner']);
$is_owner = ($user['id'] == $fld['owner']);

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

$title = $fld["name"];

$images = array();
$files = sql("SELECT images.id AS id, images.name AS name, images.extension AS extension, images.upl_date AS upl_date, ".
	"images.comment_html AS comment_html FROM images WHERE images.folder = $fldid");
while ($img = mysql_fetch_assoc($files)) $images[] = $img;

$s = sql("SELECT id, name FROM img_folders WHERE owner = " . $fld['owner'] . ($fld['owner'] == $user['id'] ? '' : " AND public != 0"). " ORDER BY name ASC");
$folers = array();
while ($f = mysql_fetch_assoc($s)) $folders[] = $f;

require("tpl/image/folder.php");
