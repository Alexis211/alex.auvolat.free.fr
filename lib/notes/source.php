<?php

assert_redir(count($args) == 3, 'notes');
$noteid = intval($args[2]);

$note = mysql_fetch_assoc(sql("SELECT id, title, text, public, owner FROM notes WHERE id = $noteid"));
assert_error($note && ($note['public'] != 0 || $note['owner'] == $user['id']),
	"This note does not exist, or you are not allowed to see it.");

//header("Content-Type: text/plain: charset=utf-8");
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<pre><? echo htmlspecialchars($note['text']); ?></pre>
</body>
</html>
<?
die();
