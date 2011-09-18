<?php

assert_redir(count($args) >= 3, 'study');
$studyid = intval($args[2]);

$study = mysql_fetch_assoc(sql(
	"SELECT ".
	" deck_study.user AS learn_user ".
	"FROM deck_study ".
	"WHERE deck_study.id = $studyid"));
assert_error($study && $study['learn_user'] == $user['id'], "You are not at the right place here.");

token_validate("Do you really want to remove this deck from your studies ? ALL YOUR PROGRESS WILL BE LOST!", "deck-study-$studyid");
sql("DELETE FROM card_study WHERE deck_study = $studyid");
sql("DELETE FROM deck_study WHERE id = $studyid");
header("Location: study");
die();
