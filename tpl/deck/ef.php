
<?php
require("tpl/general/top.php");

if (isset($fields))
	require("tpl/general/inc_form.php");

echo '</div><div class="contents-left">';

echo '<h1>' . $deck['name'] . '</h1>';
echo '<ul><li><a href="view-deck-' . $deck['id'] . '">Back to deck</a></li>';
echo '<li><a href="edit-deck-' . $deck['id'] . '">Edit deck</a></li>';
echo '<li><a href="addent-deck-' . $deck['id'] . '">Add card to deck</a></li>';
echo '</ul>';

require("tpl/general/bottom.php");
