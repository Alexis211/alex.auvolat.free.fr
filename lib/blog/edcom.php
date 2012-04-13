<?php

require("lib/markdown.php");

assert_redir(count($args) == 3, 'blog');
$comid = intval($args[2]);

$com = mysql_fetch_assoc(sql(
	"SELECT blog_comments.owner AS owner, blog_comments.text AS text, blog_comments.post AS post ".
	"FROM blog_comments WHERE id = $comid"
	));
assert_error($com && $com['owner'] == $user['id'],
	"This comment does not exist, or you are not allowed to edit it.");

$com_text = $com['text'];
if (isset($_POST['text'])) {
	$com_text = esca($_POST['text']);
	$com_text_html = Markdown($com_text);
	if (trim($com_text) == "") {
		$error = "You cannot enter an empty comment. If you want your comment to be deleted, please edit your comment so that it says so, and an administrator will delete it.";
	} else {
		sql("UPDATE blog_comments SET text = '" . escs($com_text) . "', text_html = '" . escs($com_text_html) . "' ".
			"WHERE id = $comid");;
		header("Location: view-blog-" . $com['post']);
		die();
	}
}

$title = "Edit comment";
$fields = array(
	array("label" => "Comment : ", "name" => "text", "value" => $com_text, "type" => "textarea"),
	);
$validate = "Edit comment";

require("tpl/general/form.php");
