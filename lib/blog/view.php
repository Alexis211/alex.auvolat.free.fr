<?php


assert_redir(count($args) == 3, 'blog');
$postid = intval($args[2]);

$post = mysql_fetch_assoc(sql(
	"SELECT blog_posts.id AS id, blog_posts.title AS title, blog_posts.date AS date,
		blog_posts.text AS text, blog_posts.text_html AS text_html,
		blog_posts.draft AS draft,
		account.login AS owner, blog_posts.owner AS owner_id, ".
	"GROUP_CONCAT(blog_tags.tag SEPARATOR ',  ') AS tags ".
	"FROM blog_posts LEFT JOIN blog_tags ON blog_tags.post = blog_posts.id ".
	"LEFT JOIN account ON blog_posts.owner = account.id ".
	"WHERE blog_posts.id = $postid"
));

assert_error($post && ($post['draft'] == 0 || $post['owner_id'] == $user['id']),
	"This post does not exist.");

$comments = array();
$c = sql(
	"SELECT blog_comments.id AS id, blog_comments.text_html AS text_html, ".
	"blog_comments.owner AS author_id, ".
	"blog_comments.date AS date, account.login AS author ".
	"FROM blog_comments ".
	"LEFT JOIN account ON blog_comments.owner = account.id ".
	"WHERE blog_comments.post = $postid ".
	"ORDER BY date ASC"
	);
while ($o = mysql_fetch_assoc($c)) $comments[] = $o;

$can_post = ($user['priv'] >= $apps['blog']['drafts'] && $user['id'] != 0);
$can_edit = ($user['priv'] >= $apps['blog']['edit'] && $user['id'] != 0);
$can_delete = ($user['priv'] >= $apps['blog']['delete'] && $user['id'] != 0);
$can_comment = ($user['priv'] >= $apps['blog']['comment'] && $user['id'] != 0);
$is_draft = ($post['draft'] != 0);
$can_delcom = ($user['priv'] >= $apps['blog']['delcom'] && $user['id'] != 0);

require("tpl/blog/view.php");
