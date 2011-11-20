<?php

assert_redir(count($args) == 3, 'list');
$listid = intval($args[2]);
$list = mysql_fetch_assoc(sql("SELECT id FROM lists WHERE id = $listid"));
assert_error($list, "This list does not exist.");

assert_error(!mysql_fetch_assoc(sql("SELECT id FROM list_study WHERE list = $listid AND user = " . $user['id'])),
	"You are already studying this list.");

sql("INSERT INTO list_study(user, list) VALUES(" . $user['id'] . ", $listid)");
header("Location: list-study-".mysql_insert_id());
die();
