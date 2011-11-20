<?php

assert_redir(count($args) >= 3, 'study');
$studyid = intval($args[2]);

$study = mysql_fetch_assoc(sql(
	"SELECT ".
	" list_study.user AS learn_user ".
	"FROM list_study ".
	"WHERE list_study.id = $studyid"));
assert_error($study && $study['learn_user'] == $user['id'], "You are not at the right place here.");

token_validate("Do you really want to remove this list from your studies ? Your progress will not be lost.", "list-study-$studyid");
sql("DELETE FROM list_study WHERE id = $studyid");
header("Location: study");
die();
