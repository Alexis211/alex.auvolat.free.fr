<?php

if ($user['id'] == 0) {
	$message = "You must create an account to use this study program.";
}

require("tpl/study/index.php");
