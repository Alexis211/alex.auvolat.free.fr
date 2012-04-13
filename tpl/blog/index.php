<?php
require("tpl/general/top.php");

if ($can_post) {
	echo '<div class="small_right">';
	echo '<a href="post-blog">post a message</a>';
	echo ' | <a href="drafts-blog">my drafts</a>';
	echo '</div>';
}

echo '<div class="ordering_links">' . filters_html_full() . '</div>';

foreach ($posts as $post) {
	echo '<div class="blog_post">';
	echo '<div class="small_right">Written by ' . $post['owner'];
	if ($can_edit && $post['owner_id'] == $user['id'])
		echo ' | <a href="edit-blog-' . $post['id'] . '">edit</a>';
	if ($can_delete && $post['owner_id'] == $user['id'])
		echo ' | <a href="delete-blog-' . $post['id'] . '">delete</a>';
	echo ' | <a href="view-blog-' . $post['id'] . '">read & comment (' . $post['comments'] . ')</a>';
	echo '</div>';
	echo '<div class="small_right">published ' . $post['date'] . '</div>';
	if ($post['tags'] != '') {
		echo '<div class="small_right">tags: ' . $post['tags'] . '</div>';
	}
	echo '<h2>' . $post['title'] . '</h2>';
	echo '<div class="inside">' . $post['text_html'] . '</div>';
	echo '</div>';
}

echo '</div><div class="contents-left">';

foreach ($fa as $kname => $kdata) {
	echo '<h1>Filter by ' . $kname . '</h1>';
	if (isset($fvalues[$kname])) {
		echo '<p>Filtering ' . $kname . ' : ' . $kdata[$fvalues[$kname]]['name'] . '.<br />';
		$n = array();
		foreach ($fvalues as $k => $v) {
			if ($k != $kname) $n[] = "$k-$v";
		}
		echo '<a href="index-blog-' . implode('-', $n) . '">remove filtering</a></p>';
	} else {
		echo '<ul>';
		foreach ($kdata as $vid => $vdata) {
			$n = array();
			foreach ($fvalues as $k => $v) $n[] = "$k-$v";
			$n[] = "$kname-$vid";
			echo '<li><a href="index-blog-' . implode('-', $n) . '">' . $vdata['name'] . ' (' . $vdata['count'] . ')</a></li>';
		}
		echo '</ul>';
	}
}

echo "<h1>...</h1>";
$ze = array();
foreach ($fvalues as $k => $v) { $ze[] = "$k-$v"; }
$ze[] = "feed-atom";
$zd = implode("-", $ze);
echo '<ul>';
if (count($fvalues) > 0) {
	echo '<li><a href="index-blog-' . $zd . '">Atom feed for this selection</a></li>';
	echo '<li><a href="index-blog-feed-atom">Homepage Atom feed</a></li>';
} else {
	echo '<li><a href="index-blog-feed-atom">Atom feed</a></li>';
}
echo '</ul>';

require("tpl/general/bottom.php");
