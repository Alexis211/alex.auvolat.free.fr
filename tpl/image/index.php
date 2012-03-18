<?php
require("tpl/general/top.php");

if (count($images) == 0) {
	echo '<div class="message">You have uploaded no images yet.</div>';
} else {
	echo '<p>You have uploaded ' . count($images) .' images.</p>';
	echo '<div class="ordering_links">' . filters_html_full() . '</div>';
	echo '<table><tr><th width="' . ($miniature_width) . 'px">Preview</th><th>Info</th><th>Date</th></tr>';
	foreach ($images as $img) { 
		$min = $baseurl . $img['id'] . "-min." . $img['extension'];
		$imgf = $baseurl . $img['id'] . "." . $img['extension'];
		echo '<tr><td><a href="' . $imgf . '"><img src="' . $min . '" /></a></td>';
		echo '<td><strong>' . $img['name'] . '</strong>';
		if ($img['folder_id'] != 0) {
			echo ' (in folder: <a href="folder-image-' . $img['folder_id'] . '">' . $img['folder_name'] . '</a>)';
		}
		echo '<br /><strong>MD:</strong> <code>!['.$img['name'].']('.$imgf.')</code>';
		echo '<br />' . $img['comment_html'] . '<br />';
		/*echo '<strong>Miniature:</strong> <a href="' . $min . '">' . $min . '</a><br />';
		echo '<strong>Image:</strong> <a href="' . $imgf . '">' . $imgf . '</a><br />'; */
		echo '</td>';
		echo '<td>' . $img['upl_date'] . '<br />';
		if ($can_delete) echo '<br /><a href="delete-image-' . $img['id'] . '">delete</a>';
		if ($can_rename) echo '<br /><a href="editinfo-image-' . $img['id'] . '">edit info</a>';
		echo '</td></tr>';
	} 
	echo '</table>';
}

if ($can_upload) {
?>
</div>
<div class="contents-left">
<h1>Upload an image</h1>
<form method="POST" action="index.php?p=upload-image" enctype="multipart/form-data">
A <?php echo $miniature_width; ?>px preview will be created.<br /><br />
Title : <input type="text" name="name" style="width: 200px;" ><br />
<input type="file" name="image" /><br />
<input type="submit" value="Upload" /></form>

<br /><br />
<h1>Your folders</h1>
<ul>
<?php
foreach ($folders as $f) {
	echo '<li><a href="folder-image-' . $f['id'] . '">' . $f['name'] . '</a></li>';
}
?>
<li><a class="tool_link" href="newfld-image">[+] New folder</a></li>
</ul>
<?php
}

require("tpl/general/bottom.php");
