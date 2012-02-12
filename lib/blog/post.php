<?php

require("lib/markdown.php");

$post_title = "";
$post_tags = "";
$post_text = "";
if (isset($_POST['title']) && isset($_POST['text'])) {
	$post_title = esca($_POST['title']);
	$post_text = esca($_POST['text']);
	$post_tags = esca($_POST['tags']);
	$post_html = Markdown($post_text);

	if ($post_title == "") {
		$error = "You must give a title to your post.";
	} else {
		sql("INSERT INTO blog_posts(owner, title, text, text_html, date, draft) ".
			"VALUE(" . $user['id'] . ", '" . escs($post_title) . "', '" . escs($post_text) . "', '" . escs($post_html) .
			"', NOW(), 1)");
		$id = mysql_insert_id();
		$tags = explode('  ', $post_tags);
		if (count($tags) == 1 && $tags[0] == "") {
			//do nothing lol
		} else if (count($tags) >= 1) {
			$v = array();
			foreach ($tags as $tag) {
				$v[] = "($id, '" . escs($tag) . "')";
			}
			sql("INSERT INTO blog_tags(post, tag) VALUES " . implode(',', $v));
		}
		header("Location: drafts-blog");
		die();
	}
}

$title = "Post to blog";
$fields = array(
	array("label" => "Title : ", "name" => "title", "value" => $post_title),
	array("label" => "Tags ", "name" => "tags", "type" => "text", "value" => $post_tags),
	array("label" => "Text : ", "name" => "text", "type" => "textarea", "value" => $post_text),
	);
$validate = "Post entry";

require("tpl/general/form.php");
