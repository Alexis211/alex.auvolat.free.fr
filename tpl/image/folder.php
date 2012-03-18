<?php
require("tpl/general/top.php");

if ($can_edit) {
	echo '<div class="small_right"><a href="editfld-image-' . $fldid . '">edit folder info</a> | ';
	echo '<a href="delfld-image-' . $fldid . '">delete folder</a></div>';
}

echo $fld['comment_html'];

if (count($images) == 0) {
	echo '<div class="message">This folder has no images.</div>';
} else {
	echo '<div class="ordering_links">' . filters_html_full() . '</div>';
	echo '<table><tr><th width="' . ($miniature_width) . 'px">Preview</th><th>Info</th><th>Date</th></tr>';
	foreach ($images as $img) { 
		$min = $baseurl . $img['id'] . "-min." . $img['extension'];
		$imgf = $baseurl . $img['id'] . "." . $img['extension'];
		echo '<tr><td><a href="' . $imgf . '"><img src="' . $min . '" /></a></td>';
		echo '<td><strong>' . $img['name'] . '</strong>';
		echo '<br />' . $img['comment_html'] . '<br />';
		/*echo '<strong>Miniature:</strong> <a href="' . $min . '">' . $min . '</a><br />';
		echo '<strong>Image:</strong> <a href="' . $imgf . '">' . $imgf . '</a><br />'; */
		echo '</td>';
		echo '<td>' . $img['upl_date'] . '<br />';
		if ($can_edit) echo '<br /><a href="delete-image-' . $img['id'] . '">delete</a>';
		if ($can_edit) echo '<br /><a href="editinfo-image-' . $img['id'] . '">edit info</a>';
		echo '</td></tr>';
	} 
	echo '</table>';
}

echo '</div><div class="contents-left">';
if ($is_owner) {
	echo '<h1>Your folders</h1>';
} else {
	echo '<h1>' . $fld["ownername"] . "'s folders</h1>";
}
echo '<ul>';
foreach ($folders as $f) {
	if ($f['id'] == $fldid) {
		echo '<li>' . $f['name'] . '</li>';
	} else {
		echo '<li><a href="folder-image-' . $f['id'] . '">' . $f['name'] . '</a></li>';
	}
}
if ($is_owner) {
	echo '<li><a class="tool_link" href="newfld-image">[+] New folder</a></li>';
}
echo '</ul>';

require("tpl/general/bottom.php");
