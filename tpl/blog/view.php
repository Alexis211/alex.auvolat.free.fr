<?php

$title = $post['title'];

require("tpl/general/top.php");

echo '<div class="small_right">';
echo 'Written by ' . $post['owner'];
if ($can_edit && $post['owner_id'] == $user['id'])
	echo ' | <a href="edit-blog-' . $post['id'] . '">edit</a>';
if ($can_delete && $post['owner_id'] == $user['id'])
	echo ' | <a href="delete-blog-' . $post['id'] . '">delete</a>';
if ($can_comment)
	echo ' | <a href="comment-blog-' . $post['id'] . '">post comment</a>';
echo '</div>';
echo '<div class="small_right">published ' . $post['date'] . '</div>';
if ($post['tags'] != '') {
	echo '<div class="small_right">tags: ' . $post['tags'] . '</div>';
}
echo $post['text_html'];

echo '<h2>Comments</h2>';

if (count($comments) == 0) {
	echo 'No comments at the moment.';
} else {
	foreach ($comments as $comment) {
		echo '<div class="blog_post">';
		$a = array();
		if ($can_delcom) $a[] = '<a href="delcom-blog-' . $comment['id'] . '">delete</a>';
		if ($can_comment && $comment['author_id'] == $user['id'])
			$a[] = '<a href="edcom-blog-' . $comment['id'] . '">edit</a>';
		if (count($a) > 0)
			echo '<div class="small_right">' . implode(" | ", $a) . '</div>';

		echo '<h3>' . $comment['date'] . ' by ' . $comment['author'] . '</h3>';
		echo '<div class="inside">' . $comment['text_html'] . '</div>';
		echo '</div>';
	}
}

echo '<h3>Post a comment</h3>';
if ($can_comment) {
	echo '<form class="blog_post" method="POST" action="index.php?p=comment-blog-' . $post['id'] . '"><textarea name="comment" style="height: 200px"></textarea><br /><div class="empty_label">&nbsp;</div><input type="submit" value="Comment" /></form>';
} else {
	echo 'Please log in or register to post a comment.';
}


require("tpl/general/bottom.php");
