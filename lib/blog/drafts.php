<?php

$title = "My posts";

$drafts = array();
$pub = array();

$r = sql(
	"SELECT id, title, text_html, draft FROM blog_posts WHERE owner = " . $user['id'] . " ORDER BY date DESC"
	);
while ($pp = mysql_fetch_assoc($r)) {
	if ($pp['draft']) {
		$drafts[] = $pp;
	} else {
		$pub[] = $pp;
	}
}

require("tpl/blog/drafts.php");
