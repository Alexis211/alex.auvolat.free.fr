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

	$studying_lists = array();
	$d = sql("SELECT list_study.id AS id, lists.name AS name, account.login AS username FROM list_study ".
		"LEFT JOIN lists ON lists.id = list_study.list LEFT JOIN account ON account.id = lists.owner ".
		"WHERE list_study.user = " . $user['id']);
	while($dd = mysql_fetch_assoc($d)) $studying_lists[] = $dd;

	$my_lists = array();
	$d = sql("SELECT id, name FROM lists WHERE owner = " . $user['id']);
	while ($dd = mysql_fetch_assoc($d)) $my_lists[] = $dd;

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


	echo '<h1>Studying lists</h1><ul>';
	foreach($studying_lists as $list) {
		echo '<li><code>'.$list['username'].':<a href="list-study-' . $list['id'] . '">' . $list['name'] . '</a></code></li>';
	}
	echo '<li><a class="tool_link" href="list">[+] Show all lists</a></li></ul>';

	echo '<h1>My lists</h1><ul>';
	foreach($my_lists as $list) {
		echo '<li><code><a href="view-list-' . $list['id'] . '">' . $list['name'] . '</a></code></li>';
	}
	echo '<li><a class="tool_link" href="new-list">[+] Create list</a></li></ul>';

}
