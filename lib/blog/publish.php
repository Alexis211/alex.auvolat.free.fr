<?php

assert_redir(count($args) >= 3, 'blog');
$postid = intval($args[2]);

$post = mysql_fetch_assoc(sql("SELECT owner, draft FROM blog_posts WHERE id = $postid"));
assert_error($post && $post['owner'] == $user['id'],
	"This note does not exist, or you are not allowed to delete it.");
assert_error($post['draft'] == 1, "This post is already published.");

token_validate("Are you sure this post is ready to be published ?", "blog");
sql("UPDATE blog_posts SET draft = 0, date = NOW() WHERE id = $postid");
header("Location: blog");
