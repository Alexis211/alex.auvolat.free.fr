<?php
global $sql_min_priv_for_debug;
require("top.php");

if ($user['priv'] >= $sql_min_priv_for_debug) {
	echo '<div class="error">An error happenned with the following SQL query :<br />';
	echo '<code>' . $request . '</code><br />';
	echo 'Mysql answered : ' . $sql_error . '</div>';
} else {
	echo '<div class="error">An internal error occurred, sorry.</div>';
}

require("bottom.php");
