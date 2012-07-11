<?php

assert_redir(count($args) == 4, 'study');
$cardid = intval($args[2]);

$info = mysql_fetch_assoc(sql(
	"SELECT deck_study.id AS studyid, deck_study.last_card AS last_card, deck_study.need_check AS need_check, ".
	"card_study.id AS csid, cards.id AS cardid, cards.number AS cardnumber ".
	"FROM cards LEFT JOIN deck_study ON deck_study.deck = cards.deck AND deck_study.user = " . $user['id'] . " ".
	"LEFT JOIN card_study ON card_study.deck_study = deck_study.id AND card_study.card = $cardid ".
	"WHERE cards.id = $cardid"
	));
assert_error($info, "This card does not exist.");

$studyid = intval($info['studyid']);
assert_error($studyid > 0, "You are not studying this deck.");

assert_error($info['need_check'] == 0,
	'This deck needs checking first. Please return <a href="deck-study-'.$studyid.'">here</a> first, it should do it.');

assert_error($info['cardnumber'] <= $info['last_card'] + 1, "You must first add previous cards to your study list.");

$level = intval($args[3]);
assert_error($level >= 0 && $level <= 7, "That level is invalid.");
$intervals = array(999999, 1, 2, 4, 8, 16, 32, 999999);

if ($info['cardnumber'] == $info['last_card'] + 1) {
	sql("INSERT INTO card_study(deck_study, card, level, next_review) ".
		"VALUES($studyid, $cardid, $level, ADDDATE(CURDATE(), INTERVAL " . $intervals[$level] . " DAY))");
	sql("UPDATE deck_study SET last_card = last_card + 1 WHERE id = $studyid");
} else {
	assert_error($info['csid'] > 0, "Deck is inconsistent.");
	sql("UPDATE card_study SET level = $level, next_review = ADDDATE(CURDATE(), INTERVAL " . $intervals[$level] . " DAY) WHERE id = " . $info['csid']);
}

header("Location: deck-study-$studyid");
die();
