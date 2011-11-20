<?php

assert_redir(count($args) >= 3, 'list');
$batchid = intval($args[2]);

$batch = mysql_fetch_assoc(sql(
	"SELECT lists.id AS listid, lists.owner AS listowner, lists.name AS listname, batches.name AS name, ".
	"batches.model AS model, batches.contents AS contents ".
	"FROM batches LEFT JOIN lists ON lists.id = batches.list ".
	"WHERE batches.id = $batchid"));
assert_error($batch && $batch['listowner'] == $user['id'],
	"this batch does not exist, or you are not allowed to edit it.");

token_validate("Do you really want to delete this batch ?", "view-list-" . $batch['listid']);

sql("DELETE FROM batches WHERE id = $batchid");
sql("DELETE FROM batch_study WHERE batch = $batchid");
sql("DELETE FROM batch_review WHERE batch = $batchid");
header("Location: view-list-" . $batch['listid']);
die();
