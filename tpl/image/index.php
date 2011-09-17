<?php
require("tpl/general/top.php");

echo '<h2>Images you have uploaded</h2>';
 
if (count($images) == 0) {
	echo '<div class="message">You have uploaded no images yet.</div>';
} else {
echo '<table><tr><th width="' . ($miniature_width) . 'px">Preview</th><th>Files</th></tr>';
	foreach ($images as $img) { 
		$min = $baseurl . $img['id'] . "-min." . $img['extension'];
		$imgf = $baseurl . $img['id'] . "." . $img['extension'];
		echo '<tr><td><img src="' . $min . '" /></td>';
		echo '<td><strong>Miniature:</strong> <a href="' . $min . '">' . $min . '</a><br />';
		echo '<strong>Image:</strong> <a href="' . $imgf . '">' . $imgf . '</a>';
		if ($can_delete) echo '<br /><a href="delete-image-' . $img['id'] . '">Delete this image</a>';
		echo '</td>';
	} 
	echo '</table>';
}

if ($can_upload) {
?>
</div>
<div class="contents-left">
<h1>Upload an image</h1>
<form method="POST" action="index.php?p=upload-image" enctype="multipart/form-data">
<strong>A <?php echo $miniature_width; ?>px preview will be created.</strong><br /><br />
<input type="file" name="image" /><br />
<input type="submit" value="Upload" /></form>
<?php
}

require("tpl/general/bottom.php");
