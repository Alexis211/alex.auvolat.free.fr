<?php

assert_redir(count($args) >= 3, 'blog');
$comid = intval($args[2]);

$com = mysql_fetch_assoc(sql("SELECT post FROM blog_comments WHERE id = $comid"));
assert_error($com,
	"This comment does not exist.");

token_validate("Do you really want to delete this comment ?", "view-blog-" . $com['post']);
sql("DELETE FROM blog_comments WHERE id = $comid");
header("Location: view-blog-" . $com['post']);
