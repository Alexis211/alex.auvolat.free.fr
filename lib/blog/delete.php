<?php

assert_redir(count($args) >= 3, 'blog');
$postid = intval($args[2]);

$post = mysql_fetch_assoc(sql("SELECT owner FROM blog_posts WHERE id = $postid"));
assert_error($post && $post['owner'] == $user['id'],
	"This note does not exist, or you are not allowed to delete it.");

token_validate("Do you really want to delete this post ?", "blog");
sql("DELETE FROM blog_posts WHERE id = $postid");
sql("DELETE FROM blog_tags WHERE post = $postid");
header("Location: drafts-blog");
