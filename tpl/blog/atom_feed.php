<?php
header("Content-Type: application/xml");

echo '<?xml version="1.0" encoding="utf-8"?>'."\n";
echo '<feed xmlns="http://www.w3.org/2005/Atom">'."\n";
echo '<title>' . $blog_title . '</title>'."\n";
echo '<id>' . $blog_base_url . "blog". "</id>\n";
echo '<link href="' . $blog_base_url . "blog". '" rel="self" />' . "\n";


function beginning($text, $len = 500) {
	$text = preg_replace('#<.+>#isU', ' ', $text);
	if (strlen($text) > $len) {
		$text = substr($text, 0, $len)."...";
	}
	return $text;
}

foreach ($posts as $post) {
	echo "\n<entry>\n";
	echo '<title>' . $post['title'] . "</title>\n";
	echo '<published>' . @date("c", $post['date_ts']) . "</published>\n";
	echo '<id>' . $blog_base_url . "view-blog-" . $post['id'] . "</id>\n";
	foreach (explode(',  ', $post['tags']) as $tag) {
		echo '<category term="' . $tag . '" />' . "\n";
	}
	echo '<link href="' . $blog_base_url . "view-blog-" . $post['id'] . '" />' . "\n";
	echo '<summary type="html"><![CDATA['. beginning($post['text_html']) .']]></summary>' . "\n";
	echo '<content type="html"><![CDATA['. $post['text_html'] ."]]></content>\n";
	echo "<author><name>".$post['owner']."</name></author>\n";
	echo "</entry>\n";
}

echo '</feed>';

die();

