<?php
require("top.php");
foreach ($choice as $c => $u) {
	echo '<button onclick="window.location=\'' . $u . '\'">' . $c . '</button>';
}
require("bottom.php");
