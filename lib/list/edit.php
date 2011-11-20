<?php

require("lib/markdown.php");

assert_redir(count($args) == 3, 'list');
$listid = intval($args[2]);

$list = mysql_fetch_assoc(sql(
	"SELECT lists.id AS id, lists.name AS name, lists.comment_md AS comment, account.id AS owner_id ".
	"FROM lists LEFT JOIN account ON account.id = lists.owner ".
	"WHERE lists.id = $listid"));
assert_error($list && $list['owner_id'] == $user['id'],
	"This list does not exist, or you are not allowed to edit it.");

$list_name = $list['name'];
$list_comment = $list['comment'];
if (isset($_POST['name']) && isset($_POST['comment'])) {
	$list_name = esca($_POST['name']);
	$list_comment = esca($_POST['comment']);
	$list_comment_html = Markdown($list_comment);
	if ($list_name == "") {
		$error = "You must enter a name for your list.";
	} else if (mysql_fetch_assoc(sql("SELECT id FROM lists WHERE owner = " . $user['id'] . " AND name = '" . escs($list_name) . "' AND id != $listid"))) {
		$error = "You already have a list with that title.";
	} else if ($list_comment == "") {
		$error = "Please enter a comment on your list.";
	} else {
		sql("UPDATE lists SET name = '" . escs($list_name) . "', comment_md = '" . escs($list_comment) . 
		"', comment_html = '" . escs($list_comment_html) . "' WHERE id = $listid");
		header("Location: view-list-" . $listid);
		die();
	}
}

$title = "Edit list : " . $list['name'];
$fields = array(
	array("label" => "Name : ", "name" => "name", "value" => $list_name),
	array("label" => "Comment : ", "name" => "comment", "type" => "textarea", "value" => $list_comment),
);
$validate = "Edit list";

require("tpl/list/ef.php");

