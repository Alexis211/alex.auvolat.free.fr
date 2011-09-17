<?php

$title = "Study decks";

if ($user['id'] == 0) $message = "Hey, you should create an account so that you can study with us!";

require("tpl/general/top.php");

echo '<div class="ordering_links">' . filters_html_full() . '</div>';

echo "<table><tr><th>Name</th><th>Users</th>";
foreach ($decks as $deck) {
	echo '<tr><td><code>' . $deck["owner"] . ':<a href="view-deck-' . $deck['id'] . '">' . $deck["name"] . '</a></code></td>';
	echo '<td>' . $deck["nbUsers"] . '</td></tr>';
}
echo "</table>";

require("tpl/study/lib_sidebar.php");

require("tpl/general/bottom.php");
