<?php

require("lib/markdown.php");

assert_redir(count($args) == 3, 'blog');
$postid = intval($args[2]);

$post = mysql_fetch_assoc(sql(
	"SELECT blog_posts.title AS title, blog_posts.text AS text, blog_posts.owner AS owner, blog_posts.draft AS draft, ".
	"GROUP_CONCAT(blog_tags.tag SEPARATOR '  ') AS tags ".
	"FROM blog_posts LEFT JOIN blog_tags ON blog_tags.post = blog_posts.id ".
	"WHERE id = $postid"
));
assert_error($post && $post['owner'] == $user['id'],
	"This post does not exist, or you are not allowed to edit it.");

$post_title = $post['title'];
$post_tags = $post['tags'];
$post_text = $post['text'];
if (isset($_POST['title']) && isset($_POST['tags']) && isset($_POST['text'])) {
	$post_title = esca($_POST['title']);
	$post_text = esca($_POST['text']);
	$post_html = Markdown($post_text);
	$post_tags = esca($_POST['tags']);
	if ($post_title == "") {
		$error = "You must give a title to your post.";
	} else {
		sql("UPDATE blog_posts SET title = '" . escs($post_title) . "', text = '" . escs($post_text) .
			"', text_html = '" . escs($post_html) . "'" . ($post['draft'] ? ', date = NOW()' : '') .
			" WHERE id = $postid");
		sql("DELETE FROM blog_tags WHERE post = $postid");
		$tags = explode('  ', $post_tags);
		if (count($tags) == 1 && $tags[0] == "") {
			//do nothing lol
		} else if (count($tags) >= 1) {
			$v = array();
			foreach ($tags as $tag) {
				$v[] = "($postid, '" . escs($tag) . "')";
			}
			sql("INSERT INTO blog_tags(post, tag) VALUES " . implode(',', $v));
		}
		if ($post['draft']) {
			header("Location: drafts-blog");
		} else {
			header("Location: blog");
		}
		die();
	}
}

$title = "Edit : " . $post['title'];
$fields = array(
	array("label" => "Title : ", "name" => "title", "value" => $post_title),
	array("label" => "Tags :  ", "name" => "tags", "type" => "text", "value" => $post_tags),
	array("label" => "Text : ", "name" => "text", "type" => "textarea", "value" => $post_text),
	);
$validate = "Edit post";

require("tpl/general/form.php");


