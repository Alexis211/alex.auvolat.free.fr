<?php

require("tpl/general/top.php");

if (isset($parent)) {
	echo '<div class="small_right"><a href="view-notes-' . $parent['id'] . '">back to ' .
		$parent['title'] . '</a></div>';
}

require("tpl/general/inc_form.php");

if (isset($parent)) {
	$note = $parent;
	$can_new = false;
	require("tpl/notes/inc_relativestree.php");
}

require("tpl/general/bottom.php");
