<?php
require("tpl/general/top.php");

if (count($files) == 0) {
	echo '<p>You have no files that are uploaded and not put in a folder.</p>';
} else {
	echo '<p>You have ' . count($files) .' files uploaded in no folder. Select a folder to view the files it contains.</p>';
	echo '<div class="ordering_links">' . filters_html_full() . '</div>';
	echo '<table><tr><th width="' . ($img_mini_width) . 'px"></th><th>Info</th><th width="120px">Date</th></tr>';
	foreach ($files as $fl) { 
		$min = $baseurl . $fl['id'] . "-min." . $fl['extension'];
		$flf = $baseurl . $fl['id'] . "." . $fl['extension'];
		echo '<tr><td style="text-align: center; vertical-align: middle"><a href="' . $flf . '">';
		if (has_mini($fl['extension'])) {
			echo '<img src="' . $min . '" />';
		} else {
			echo 'download';
		}
		echo '</a></td>';
		echo '<td><strong>' . $fl['name'] . '</strong>';
		if ($fl['folder_id'] != 0) {
			echo ' (in folder: <a href="folder-file-' . $fl['folder_id'] . '">' . $fl['folder_name'] . '</a>)';
		}
		echo '<br /><strong>MD:</strong> <code>' . (has_mini($fl['extension']) ? '!' : '') . '['.$fl['name'].']('.$flf.')</code>';
		echo '<br />' . $fl['comment_html'] . '<br />';
		/*echo '<strong>Miniature:</strong> <a href="' . $min . '">' . $min . '</a><br />';
		echo '<strong>Image:</strong> <a href="' . $flf . '">' . $flf . '</a><br />'; */
		echo '</td>';
		echo '<td>' . $fl['upl_date'] . '';
		if ($can_delete) echo '<br /><a href="delete-file-' . $fl['id'] . '">delete</a>';
		if ($can_rename) echo ' | <a href="editinfo-file-' . $fl['id'] . '">edit</a>';
		echo '</td></tr>';
	} 
	echo '</table>';
}

if ($can_upload) {
?>
</div>
<div class="contents-left">
<h1>Upload a file</h1>
<form method="POST" action="index.php?p=upload-file" enctype="multipart/form-data">
If you upload an image, a <?php echo $img_mini_width; ?>px preview will be created.<br /><br />
Title : <input type="text" name="name" style="width: 200px;" ><br />
<input type="file" name="file" /><br />
<input type="submit" value="Upload" /></form>

<br /><br />
<h1>Your folders</h1>
<ul>
<?php
foreach ($folders as $f) {
	echo '<li><a href="folder-file-' . $f['id'] . '">' . $f['name'] . '</a></li>';
}
?>
<li><a class="tool_link" href="newfld-file">[+] New folder</a></li>
</ul>
<?php
}

require("tpl/general/bottom.php");
