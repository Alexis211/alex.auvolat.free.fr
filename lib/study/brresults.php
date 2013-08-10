<?php

assert_redir(count($args) == 3, 'study');
$batchid = intval($args[2]);

$info = mysql_fetch_assoc(sql(
	"SELECT list_study.id AS studyid, ".
	"batch_study.id AS bsid, batches.id AS batchid, batches.json_data AS json_data ".
	"FROM batches LEFT JOIN list_study ON list_study.list = batches.list AND list_study.user = " . $user['id'] . " " .
	"LEFT JOIN batch_study ON batch_study.batch = $batchid AND batch_study.user = " . $user['id'] . " " .
	"WHERE batches.id = $batchid"));
if (!($info)) {
	echo "This batch does not exist";
	die();
}
if (!($info['studyid'] != 0)) {
	echo "You are not studying this list.";
	die();
}

if ($info["bsid"] == 0) {
	sql("INSERT INTO batch_study(user, batch, last_review, notes_json) ".
		"VALUES(" . $user['id'] . ", $batchid, 0, '{}')");
	$info['bsid'] = mysql_insert_id();
	$info['notes'] = '{}';
}

if (isset($_POST['results']) && isset($_POST['score'])) {
	sql("INSERT INTO batch_review(user, batch, results, score, date) ".
		"VALUES(" . $user['id'] . ", $batchid, '" . escs(esca($_POST['results'])) . "', " . intval($_POST['score']) . ", NOW())");
	sql("UPDATE batch_study SET last_review = " . mysql_insert_id() . " WHERE id = " . $info['bsid']);
	echo 'Saved';
} else if (isset($_POST['notes'])) {
	sql("UPDATE batch_study SET notes_json = '" . escs(esca($_POST['notes'])) . "' WHERE id = " . $info['bsid']);
	echo 'Saved';
} else {
	echo 'Error';
}

die();
