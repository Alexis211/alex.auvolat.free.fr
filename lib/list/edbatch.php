<?php

require("lib/list/inc_process.php");

assert_redir(count($args) == 3, 'list');
$batchid = intval($args[2]);

$batch = mysql_fetch_assoc(sql(
	"SELECT lists.id AS listid, lists.owner AS listowner, lists.name AS listname, batches.name AS name, ".
	"batches.model AS model, batches.contents AS contents ".
	"FROM batches LEFT JOIN lists ON lists.id = batches.list ".
	"WHERE batches.id = $batchid"));
assert_error($batch && $batch['listowner'] == $user['id'],
	"this batch does not exist, or you are not allowed to edit it.");
$list = array("id" => $batch['listid'], 'name' => $batch['listname']);

$batch_name = $batch['name'];
$batch_model = $batch['model'];
$batch_contents = $batch['contents'];
if (isset($_POST['name']) && isset($_POST['model']) && isset($_POST['contents'])) {
	$batch_name = esca($_POST['name']);
	$batch_model = esca($_POST['model']);
	$batch_contents = esca($_POST['contents']);
	$batch_json = mk_batch_json($batch_model, $batch_contents);
	if ($batch_name == "") {
		$error = "You must give a name to this batch.";
	} else if (mysql_fetch_assoc(sql("SELECT id FROM batches WHERE list = " . $list['id'] . " AND name = '" . escs($batch_name) . "' AND id != $batchid"))) {
		$error = "You already have a batch using that name.";
	} else {
		sql(
			"UPDATE batches SET name = '" . escs($batch_name) . "', model = '" . escs($batch_model) . "', ".
			"contents = '" . escs($batch_contents) . "', json_data = '" . escs($batch_json) . "' WHERE id = $batchid"
		);
		header("Location: view-list-" . $list['id']);
		die();
	}
}

$title = "Edit batch in " . $list['name'];
$fields = array(
	array("label" => "Name : ", "name" => "name", "value" => $batch_name),
	array("label" => "Columns : ", "name" => "model", "value" => $batch_model),
	array("label" => "Contents : ", "name" => "contents", "type" => "textarea", "value" => $batch_contents)
);
$validate = "Edit batch";

require("tpl/list/ef.php");
