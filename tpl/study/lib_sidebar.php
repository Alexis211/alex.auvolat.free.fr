<?php

if ($user['id'] != 0) {
	$my_decks = array();
	$d = sql("SELECT id, name FROM decks WHERE owner = " . $user['id']);
	while ($dd = mysql_fetch_assoc($d)) $my_decks[] = $dd;

	echo '</div><div class="contents-left">';
	echo '<h1>Studying decks</h1><ul>';
	//LIST
	echo '<li><a class="tool_link" href="deck">[+] Show all decks</a></li></ul>';

	echo '<h1>My decks</h1><ul>';
	foreach($my_decks as $deck) {
		echo '<li><a href="view-deck-' . $deck['id'] . '">' . $deck['name'] . '</a></li>';
	}
	echo '<li><a class="tool_link" href="new-deck">[+] Create deck</a></li></ul>';
}
