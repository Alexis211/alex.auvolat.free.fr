<?php

assert_redir(count($args) == 3, 'notes');
$noteid = intval($args[2]);

$note = mysql_fetch_assoc(sql(
	"SELECT na.id AS id, na.title AS title, na.text_html AS html, na.public AS public, na.owner AS owner, ".
	"nb.title AS parent_title, nb.id AS parent_id, account.login AS ownername FROM notes na ".
	"LEFT JOIN notes nb ON na.parent = nb.id LEFT JOIN account ON account.id = na.owner ".
	"WHERE na.id = $noteid"
));
assert_error($note && ($note['public'] != 0 || $note['owner'] == $user['id']),
	"This note does not exist, or you are not allowed to see it.");

$can_new = ($user['priv'] >= $apps['notes']['new'] && $user['id'] == $note['owner']);
$can_edit = ($user['priv'] >= $apps['notes']['edit'] && $user['id'] == $note['owner']);
$can_delete = ($user['priv'] >= $apps['notes']['delete'] && $user['id'] == $note['owner']);
$can_move = ($user['priv'] >= $apps['notes']['move'] && $user['id'] == $note['owner']);

require("tpl/notes/view.php");

