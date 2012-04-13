<?php

require("lib/markdown.php");

assert_redir(count($args) == 3, 'blog');
$postid = intval($args[2]);

$post = mysql_fetch_assoc(sql(
	"SELECT blog_posts.id AS id, blog_posts.title AS title,
		blog_posts.draft AS draft ".
	"FROM blog_posts LEFT JOIN blog_tags ON blog_tags.post = blog_posts.id ".
	"WHERE blog_posts.id = $postid"
));

assert_error($post && $post['draft'] == 0,
	"This post does not exist.");

$comment = "";
if (isset($_POST['comment'])) {
	$comment = esca($_POST['comment']);
	$comment_html = Markdown($comment);

	if (trim($comment) == "") {
		$error = "You cannot enter an empty comment.";
	} else {
		sql("INSERT INTO blog_comments(owner, post, text, text_html, date) ".
			"VALUES(" . $user['id'] . ", $postid, '" . escs($comment) . "', '" . escs($comment_html) . "', NOW())");
		header("Location: view-blog-$postid");
		die();
	}
}

$title = "Comment '" . $post['title'] . "'";
$fields = array(
	array("label" => "Comment : ", "name" => "comment", "type" => "textarea", "value" => $comment),
	);
$validate = "Comment";
require("tpl/general/form.php");
