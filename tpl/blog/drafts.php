<?php

require("tpl/general/top.php");

echo '<div class="small_right">';
echo '<a href="post-blog">post a message</a></div>';

echo '<h2>My drafts</h2>';

if (count($drafts) > 0) {
	foreach ($drafts as $post) {
		echo '<div class="blog_post">';
		echo '<div class="small_right">';
		echo '<a href="edit-blog-' . $post['id'] . '">edit</a>';
		echo ' | <a href="delete-blog-' . $post['id'] . '">delete</a>';
		echo ' | <a href="publish-blog-' . $post['id'] . '">publish</a>';
		echo '</div>';
		echo '<h2>' . $post['title'] . '</h2>';
		echo $post['text_html'];
		echo '</div>';
	}
} else {
	echo '<p>No drafts</p>';
}

echo '<h2>My published posts</h2>';

if (count($pub) > 0) {
	echo '<table><tr><th>Title</th><th>Actions</th></tr>';
	foreach ($pub as $post) {
		echo '<tr><td>' . $post['title'] . '</td>';
		echo '<td><a href="edit-blog-' . $post['id'] . '">edit</a>';
		echo ' | <a href="delete-blog-' . $post['id'] . '">delete</a></td></tr>';
	}
	echo '</table>';
} else {
	echo '<p>No published posts</p>';
}


require("tpl/general/bottom.php");
