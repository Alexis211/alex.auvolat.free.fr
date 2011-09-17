<?php

require("tpl/general/top.php");

echo '<div class="small_right"><a href="view-notes-' . $note['id'] . '">return to note</a></div>';

require("tpl/general/inc_form.php");

if (isset($preview)) {
	echo '<hr /><h1>Preview</h1>';
	echo' <div class="error">Warning : this is only a preview. Click the "Edit note" button above to save changes.</div>';
	echo $preview;
}

$can_new = false;
require("tpl/notes/inc_relativestree.php");
require("tpl/general/bottom.php");
