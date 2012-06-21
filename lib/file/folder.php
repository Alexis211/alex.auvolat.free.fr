<?php

require("lib/conf/file.php");

assert_redir(count($args) == 3, 'file');
$fldid = intval($args[2]);

$fld = mysql_fetch_assoc(sql(
	"SELECT folders.id AS id, folders.name AS name, folders.comment_html AS comment_html, ".
	"folders.public AS public, account.id AS owner, account.login AS ownername FROM folders ".
	"LEFT JOIN account ON account.id = folders.owner ".
	"WHERE folders.id = $fldid"
));
assert_error($fld && ($fld['public'] != 0 || $fld['owner'] == $user['id']),
	"This folder does not exist, or you are not allowed to see it.");

$can_edit = ($user['priv'] >= $apps['file']['editfld'] && $user['id'] == $fld['owner']);
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

$files = array();
$fileq = sql("SELECT files.id AS id, files.name AS name, files.extension AS extension, files.upl_date AS upl_date, ".
	"files.comment_html AS comment_html FROM files WHERE files.folder = $fldid");
while ($img = mysql_fetch_assoc($fileq)) $files[] = $img;

$s = sql("SELECT id, name FROM folders WHERE owner = " . $fld['owner'] . ($fld['owner'] == $user['id'] ? '' : " AND public != 0"). " ORDER BY name ASC");
$folers = array();
while ($f = mysql_fetch_assoc($s)) $folders[] = $f;

require("tpl/file/folder.php");
