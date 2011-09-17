<?php

$title = $deck["owner"] . ':' . $deck["name"];

require("tpl/general/top.php");

if ($can_edit) {
	echo '<div class="small_right"><a href="edit-deck-' . $deck['id'] . '">edit</a> | ';
	echo '<a href="addent-deck-' . $deck['id'] . '">add card</a></div>';
}

echo '<h3>Description</h3>';
echo $deck["comment"];

echo '<h3>Cards</h3>';
echo '<div class="ordering_links">' . filters_html_full() . '</div>';
foreach ($cards as $card) {
	echo '<div class="study_card">';
	if ($can_edit) {
		echo '<div class="small_right"><a href="edent-deck-' . $card['id'] . '">edit</a> | <a href="rment-deck-' . $card['id'] . '">remove</a> | ';
		echo '<a href="#" onclick="if (pos = prompt(\'What position do you want to move this card to ?\', ' . $card['number'] . ')) { window.location = \'mvent-deck-' . $card['id'] . '-\' + pos; }">move</a>';
		echo '</div>';
	}
	echo '<code>#' . $card["number"] . ": " . $card["name"] . '</code>';
	echo '<br />' . $card['text'];
	echo '</div>';
}
if ($can_edit)
	echo '<a class="tool_link" href="addent-deck-' . $deck['id'] . '">[+] add card</a>';

require("tpl/study/lib_sidebar.php");

require("tpl/general/bottom.php");
