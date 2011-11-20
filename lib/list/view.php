<?php

assert_redir(count($args) == 3, 'list');
$listid = intval($args[2]);

$list = mysql_fetch_assoc(sql(
	"SELECT lists.id AS id, lists.name AS name, lists.comment_html AS comment, account.login AS owner, ".
	"account.id AS owner_id ".
	"FROM lists LEFT JOIN account ON account.id = lists.owner ".
	"WHERE lists.id = $listid"));
assert_error($list, "This list does not exist.");

$can_edit = false;
if ($list["owner_id"] == $user['id']) $can_edit = true;

$batches = array();
$n = sql(
		"SELECT id, name FROM batches WHERE list = $listid ".
		"ORDER BY name ASC"
	);
while ($nn = mysql_fetch_assoc($n)) $batches[] = $nn;

$can_start_study = false;
if ($user['id'] != 0) {
	if (!mysql_fetch_assoc(sql("SELECT id FROM list_study WHERE list = $listid AND user = " . $user['id'])))
		$can_start_study = true;
} else {
	$message = "You should create an account in order to study this list.";
}

require("tpl/list/view.php");
