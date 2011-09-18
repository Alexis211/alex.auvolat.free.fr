<?php

assert_redir(count($args) >= 3, 'study');
$studyid = intval($args[2]);

$study = mysql_fetch_assoc(sql(
	"SELECT decks.id AS deckid, decks.name AS deckname, account.login AS deckowner, ".
	" deck_study.learn_rate AS learn_rate, deck_study.user AS learn_user ".
	"FROM deck_study LEFT JOIN decks ON deck_study.deck = decks.id LEFT JOIN account ON account.id = decks.owner ".
	"WHERE deck_study.id = $studyid"));
assert_error($study && $study['learn_user'] == $user['id'], "You are not at the right place here.");

if (isset($args[3]) && ($rate = intval($args[3])) > 0) {
	sql("UPDATE deck_study SET learn_rate = $rate WHERE id = $studyid");
	header("Location: deck-study-$studyid");
	die();
}

include ("tpl/study/setrate.php");
