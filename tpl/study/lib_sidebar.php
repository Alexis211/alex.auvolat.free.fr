<?php

if ($user['id'] != 0) {
	$studying_decks = array();
	$d = sql("SELECT deck_study.id AS id, decks.name AS name, account.login AS username FROM deck_study ".
		"LEFT JOIN decks ON decks.id = deck_study.deck LEFT JOIN account ON account.id = decks.owner ".
		"WHERE deck_study.user = ".$user['id']);
	while($dd = mysql_fetch_assoc($d)) $studying_decks[] = $dd;

	$my_decks = array();
	$d = sql("SELECT id, name FROM decks WHERE owner = " . $user['id']);
	while ($dd = mysql_fetch_assoc($d)) $my_decks[] = $dd;

	echo '</div><div class="contents-left">';
	echo '<h1>Studying decks</h1><ul>';
	foreach($studying_decks as $deck) {
		echo '<li><code>'.$deck['username'].':<a href="deck-study-' . $deck['id'] . '">' . $deck['name'] . '</a></code></li>';
	}
	echo '<li><a class="tool_link" href="deck">[+] Show all decks</a></li></ul>';

	echo '<h1>My decks</h1><ul>';
	foreach($my_decks as $deck) {
		echo '<li><code><a href="view-deck-' . $deck['id'] . '">' . $deck['name'] . '</a></code></li>';
	}
	echo '<li><a class="tool_link" href="new-deck">[+] Create deck</a></li></ul>';
}
