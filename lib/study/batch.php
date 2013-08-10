<?php

assert_redir(count($args) == 3, 'study');
$batchid = intval($args[2]);

$info = mysql_fetch_assoc(sql(
	"SELECT list_study.id AS studyid, batches.name AS bname, ".
	"lists.name AS lname, account.login AS uname, ".
	"batch_study.id AS bsid, batch_study.notes_json AS notes, ".
	"batches.id AS batchid, batches.json_data AS json_data ".
	"FROM batches LEFT JOIN list_study ON list_study.list = batches.list AND list_study.user = " . $user['id'] . " " .
	"LEFT JOIN batch_study ON batch_study.batch = $batchid AND batch_study.user = " . $user['id'] . " " .
	"LEFT JOIN lists ON batches.list = lists.id ".
	"LEFT JOIN account ON account.id = lists.owner ".
	"WHERE batches.id = $batchid"));
assert_error($info, "This batch does not exist.");
assert_error($info['studyid'] != 0, "You are not studying this list.");

if ($info["bsid"] == 0) {
	sql("INSERT INTO batch_study(user, batch, last_review, notes_json) ".
		"VALUES(" . $user['id'] . ", $batchid, 0, '{}')");
	$info['bsid'] = mysql_insert_id();
	$info['notes'] = '{}';
}

$reviews = array();
$d = sql("SELECT results, score, date, batch FROM batch_review WHERE batch = $batchid AND user = " . $user['id'] ." ORDER BY date ASC");
while ($r = mysql_fetch_assoc($d)) {
	$reviews[] = '{"batch": ' . $r['batch'] . ', "date" : "' . $r['date'] . '", '.
		'"score": ' . $r['score'] . ', "results": ' . $r['results'] . '}';
}
$reviews = '[' . implode(', ', $reviews) . ']';

require("tpl/study/batch.php");
