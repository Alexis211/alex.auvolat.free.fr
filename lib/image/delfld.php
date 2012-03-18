<?php

assert_redir(count($args) >= 3, 'image');
$fldid = intval($args[2]);

$fld = mysql_fetch_assoc(sql(
	"SELECT id, name, comment, public, owner ".
	"FROM img_folders WHERE id = $fldid"
	));
assert_error($fld && $fld['owner'] == $user['id'],
	"This folder does not exist, or you are not allowed to edit it.");

token_validate("Do you really want to delete this folder ?", "folder-image-$fldid");
sql("DELETE FROM img_folders WHERE id = $fldid");
sql("UPDATE images SET folder = 0 WHERE folder = $fldid");
header("location: image");
