<?php

assert_redir(count($args) == 3, 'deck');
$deckid = intval($args[2]);
$deck = mysql_fetch_assoc(sql("SELECT id FROM decks WHERE id = $deckid"));
assert_error($deck, "This deck does not exist.");

assert_error(!mysql_fetch_assoc(sql("SELECT id FROM deck_study WHERE deck = $deckid AND user = " . $user['id'])),
	"You are already studying this deck.");

sql("INSERT INTO deck_study(user, deck) VALUES(" . $user['id'] . ", $deckid)");
header("Location: deck-study-".mysql_insert_id());
die();
