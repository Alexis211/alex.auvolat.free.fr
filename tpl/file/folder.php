<?php
require("tpl/general/top.php");

if ($can_edit) {
	echo '<div class="small_right"><a href="editfld-file-' . $fldid . '">edit folder info</a> | ';
	echo '<a href="delfld-file-' . $fldid . '">delete folder</a></div>';
}

echo $fld['comment_html'];

if (count($files) == 0) {
	echo '<div class="message">This folder has no files.</div>';
} else {
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
		echo '<br /><strong>MD:</strong> <code>' . (has_mini($fl['extension']) ? '!' : '') . '['.$fl['name'].']('.$flf.')</code>';
		echo '<br />' . $fl['comment_html'] . '<br />';
		echo '</td>';
		echo '<td>' . $fl['upl_date'];
		if ($can_edit) echo '<br /><a href="delete-file-' . $fl['id'] . '">delete</a>';
		if ($can_edit) echo ' | <a href="editinfo-file-' . $fl['id'] . '">edit</a>';
		echo '</td></tr>';
	} 
	echo '</table>';
}

echo '</div><div class="contents-left">';

if ($is_owner) {
	?>
<h1>Upload a file</h1>
<form method="POST" action="index.php?p=upload-file" enctype="multipart/form-data">
If you upload an image, a <?php echo $img_mini_width; ?>px preview will be created.<br /><br />
Title : <input type="text" name="name" style="width: 200px;" ><br />
<input type="file" name="file" /><br />
<input type="hidden" name="folder" value="<?php echo $fldid; ?>" />
<input type="submit" value="Upload" /></form>
<br /><br />
	<?php
}

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
		echo '<li><a href="folder-file-' . $f['id'] . '">' . $f['name'] . '</a></li>';
	}
}
if ($is_owner) {
	echo '<li><a class="tool_link" href="file">[files in no folder]</a></li>';
	echo '<li><a class="tool_link" href="newfld-file">[+] New folder</a></li>';
}
echo '</ul>';

require("tpl/general/bottom.php");
