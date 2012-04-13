<?php

require ("lib/conf/blog.php");
$title = $blog_title;

$filters = array (
	"order" => array (
		"title" => "title",
		"owner" => "author name",
		"date" => "date published",
	),
	"way" => $ord_ways,
);
$fdefaults = array (
	"order" => "date",
	"way" => "DESC",
);

$posts = array();

$fa = array (
	"author" => array(),
	"date" => array(),
	"tag" => array(),
);
$fvalues = array();
for ($i = 2; $i < count($args); $i += 2) {
	if (isset($args[$i+1])) {
		$fvalues[$args[$i]] = urldecode($args[$i+1]);
	}
}
function count_in($fat, $v, $d) {
	global $fa;
	if (isset($fa[$fat][$v])) {
		$fa[$fat][$v]['count']++;
	} else {
		$fa[$fat][$v] = array('name' => $d, 'count' => 1);
	}
}

$q =
	"SELECT blog_posts.id AS id, blog_posts.title AS title, blog_posts.date AS date, ".
	"UNIX_TIMESTAMP(blog_posts.date) AS date_ts, ".
	"DATE_FORMAT(blog_posts.date, '%Y-%m') AS month, ".
	"blog_posts.text_html AS text_html, GROUP_CONCAT(DISTINCT ba.tag SEPARATOR ',  ') AS tags, ".
	"COUNT(DISTINCT blog_comments.id) AS comments, ".
	"account.login AS owner, account.id AS owner_id ".
	"FROM blog_posts LEFT JOIN account ON blog_posts.owner = account.id ".
	"LEFT JOIN blog_comments ON blog_comments.post = blog_posts.id ".
	"LEFT JOIN blog_tags ba ON ba.post = blog_posts.id ".
	(isset($fvalues['tag']) ? "LEFT JOIN blog_tags bb ON bb.post = blog_posts.id AND bb.tag = '" . escs($fvalues['tag'])."' " : "").
	"WHERE blog_posts.draft = 0 ".
	(isset($fvalues['author']) ? 'AND blog_posts.owner = ' . intval($fvalues['author']) .' ' : '').
	(isset($fvalues['date']) ? "AND blog_posts.date >= '" . escs(str_replace('.', '-', $fvalues['date'])) ."-01 00:00:00' " .
		"AND blog_posts.date <= '" . escs(str_replace('.', '-', $fvalues['date'])) . "-31 23:59:59'" : '').
	(isset($fvalues['tag']) ? " AND bb.post != 0 " : "").
	"GROUP BY blog_posts.id ".
	"ORDER BY " . get_filter('order') . " " . get_filter('way');
$n = sql($q);


while ($pp = mysql_fetch_assoc($n)) {
	$posts[] = $pp;
	count_in('author', $pp['owner_id'], $pp['owner']);
	$tags = explode(',  ', $pp['tags']);
	foreach ($tags as $tag) {
		count_in('tag', $tag, $tag);
	}
	count_in('date', str_replace('-', '.', $pp['month']), $pp['month']);
}

$can_post = ($user['priv'] >= $apps['blog']['drafts'] && $user['id'] != 0);
$can_edit = ($user['priv'] >= $apps['blog']['edit'] && $user['id'] != 0);
$can_delete = ($user['priv'] >= $apps['blog']['delete'] && $user['id'] != 0);


if (isset($fvalues['feed']) && $fvalues['feed'] == "atom") {
	require("tpl/blog/atom_feed.php");
} else {
	require("tpl/blog/index.php");
}
