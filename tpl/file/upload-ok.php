<?php
require("tpl/general/top.php");

$minurl = $baseurl . $id . "-min." . $type;
$imgurl = $baseurl . $id . "." . $type;

?>
	<p>Preview : <a href="<?php echo $minurl; ?>"><?php echo $minurl; ?></a><br />
	Image : <a href="<?php echo $imgurl; ?>"><?php echo $imgurl; ?></a><br />
	Markdown code : <code><?php echo (has_mini($type) ? '!' : '') . '[' . $name; ?>](<?php echo $imgurl; ?>)</code></p>
	<p>
	<p>
	<a href="upload-file">Back to upload form</a>
	<?php
	if ($user['priv'] >= $apps['file']['index'])
		echo ' - <a href="index-file">back to list of uploaded files</a>';
	?>
	</p>
<?php

require("tpl/general/bottom.php");
