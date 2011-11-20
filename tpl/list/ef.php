<?php
require("tpl/general/top.php");

if (isset($fields))
	require("tpl/general/inc_form.php");

echo '</div><div class="contents-left">';

echo '<h1>' . $list['name'] . '</h1>';
echo '<ul><li><a href="view-list-' . $list['id'] . '">Back to list</a></li>';
echo '<li><a href="edit-list-' . $list['id'] . '">Edit list</a></li>';
echo '<li><a href="addbatch-list-' . $list['id'] . '">Add batch to list</a></li>';
echo '</ul>';

require("tpl/general/bottom.php");
