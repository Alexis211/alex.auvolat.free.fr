<?php

require("lib/list/inc_process.php");

assert_redir(count($args) == 3, 'list');
$listid = intval($args[2]);

$list = mysql_fetch_assoc(sql(
	"SELECT lists.id AS id, lists.name AS name, lists.owner AS owner_id ".
	"FROM lists WHERE lists.id = $listid"));
assert_error($list && $list['owner_id'] == $user['id'],
	"This list does not exist, or you are not allowed to edit it.");

$batch_name = "";
$batch_model = "";
$batch_contents = "";
if (isset($_POST['name']) && isset($_POST['model']) && isset($_POST['contents'])) {
	$batch_name = esca($_POST['name']);
	$batch_model = esca($_POST['model']);
	$batch_contents = esca($_POST['contents']);
	$batch_json = mk_batch_json($batch_model, $batch_contents);
	if ($batch_name == "") {
		$error = "You must give a name to this batch.";
	} else if (mysql_fetch_assoc(sql("SELECT id FROM batches WHERE list = $listid AND name = '" . escs($batch_name) . "'"))) {
		$error = "You already have a batch using that name.";
	} else {
		sql(
			"INSERT INTO batches(list, name, model, contents, json_data) ".
			"VALUES($listid, '" . escs($batch_name) . "', '" . escs($batch_model) . "', '" . escs($batch_contents) . "', '" . escs($batch_json) . "')");
		header("Location: view-list-$listid");
		die();
	}
}

$title = "Add batch to " . $list['name'];
$fields = array(
	array("label" => "Name : ", "name" => "name", "value" => $batch_name),
	array("label" => "Columns : ", "name" => "model", "value" => $batch_model),
	array("label" => "Contents : ", "name" => "contents", "type" => "textarea", "value" => $batch_contents)
);
$validate = "Add batch";

require("tpl/list/ef.php");
