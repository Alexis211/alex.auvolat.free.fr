<?php

assert_redir(count($args) == 3, 'study');
$studyid = intval($args[2]);

$study = mysql_fetch_assoc(sql(
	"SELECT decks.id AS deckid, decks.name AS deckname, account.login AS deckowner, ".
	" deck_study.learn_rate AS learn_rate, deck_study.user AS learn_user, deck_study.need_check AS need_check, deck_study.last_card AS last_card ".
	"FROM deck_study LEFT JOIN decks ON deck_study.deck = decks.id LEFT JOIN account ON account.id = decks.owner ".
	"WHERE deck_study.id = $studyid"));
assert_error($study && $study['learn_user'] == $user['id'], "You are not at the right place here.");

if ($study['need_check']) {
	/* Algorithm :
	   - Check that deck_study.last_card = max(card_study.card.number)
	   - Check that foreach (card where card.deck = deck_study.deck && card.number < deck_study.last_card), 
	   			exists corresponding card_study, if not exist, create level 0 (skipped)
	*/
	$mcn = mysql_fetch_assoc(sql("SELECT MAX(cards.number) AS mcn FROM deck_study ".
		"LEFT JOIN card_study ON card_study.deck_study = deck_study.id LEFT JOIN cards ON cards.id = card_study.card ".
		"WHERE deck_study.id = $studyid"));
	$hasmoar = false;
	if ($mcn) {
		$mcn = $mcn['mcn'];
		if ($study['last_card'] != $mcn) sql('UPDATE deck_study SET last_card = ' . $mcn . ' WHERE id = ' . $studyid);

		$cs = array();
		for($i = 1; $i < $mcn; $i++) $cs[$i] = 0;

		$d = sql("SELECT cards.number AS n, card_study.id AS i FROM card_study LEFT JOIN cards ON cards.id = card_study.card ".
			"WHERE card_study.deck_study = $studyid");
		while($r = mysql_fetch_assoc($d)) $cs[$r['n']] = $r['i'];

		for ($i = 1; $i < $mcn; $i++) {
			if ($cs[$i] == 0) {
				$n = mysql_fetch_assoc(sql("SELECT cards.id AS id FROM deck_study LEFT JOIN cards ON cards.deck = deck_study.deck AND cards.number = $i ".
					"WHERE deck_study.id = $studyid"));
				assert_error($n, "Fucking deck inconsistency.");
				sql("INSERT INTO card_study(deck_study, card, level, next_review) ".
					"VALUES($studyid, " . $n['id'] . ", 0, ADDDATE(CURDATE(), INTERVAL 999999 DAY))");
				$hasmoar = true;
			}
		}
	}
	sql("UPDATE deck_study SET need_check = 0 WHERE id = $studyid");
	$message = "This deck has been checked. " . ($hasmoar ? "Some cards you hadn't studied before were added to your skipped list." : "");
}


$load = mysql_fetch_assoc(sql("SELECT SUM(4 - level) AS l FROM card_study WHERE deck_study = $studyid AND level < 4 AND level > 0"));
$load = intval($load['l']);

if ($load < $study['learn_rate']) {
	$next_card = mysql_fetch_assoc(sql("SELECT * FROM cards WHERE deck = " . $study['deckid'] . " AND number = " . ($study['last_card'] + 1)));
}



$filters = array(
	"what" => array(
		"level > 0 AND next_review <= CURDATE()" => "study today",
		"level > 0 AND level < 4" => "learning",
		"level > 0" => "all except skipped",
		"level = 0" => "skipped",
	),
	"order" => array(
		"level" => "level",
		"number" => "card number",
	),
	"way" => $ord_ways,
);
$fdefaults = array(
	"what" => "level > 0 AND level < 4",
	"order" => "level",
	"way" => "ASC",
);

$study_cards = array();
$s = sql(
	"SELECT cards.id AS id, cards.name AS name, cards.text_html AS text, cards.number AS number, ".
	"card_study.level AS level, card_study.next_review <= CURDATE() AS must_study ".
	"FROM card_study LEFT JOIN cards ON card_study.card = cards.id WHERE deck_study = $studyid AND " . get_filter("what") .
	" ORDER BY " . get_filter("order") . " " . get_filter('way') . (get_filter("order") == "level" ? ", number " . get_filter("way") : ""));
while ($ss = mysql_fetch_assoc($s)) $study_cards[] = $ss;



require("tpl/study/deck.php");
