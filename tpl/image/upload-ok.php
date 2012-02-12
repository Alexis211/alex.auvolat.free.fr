<?php
require("tpl/general/top.php");

$minurl = $baseurl . $id . "-min." . $type;
$imgurl = $baseurl . $id . "." . $type;

?>
	<p>Preview : <a href="<?php echo $minurl; ?>"><?php echo $minurl; ?></a><br />
	Image : <a href="<?php echo $imgurl; ?>"><?php echo $imgurl; ?></a><br />
	Markdown code : <code>![<?php echo $name; ?>](<?php echo $imgurl; ?>)</code></p>
	<p>
	<p>
	<a href="upload-image">Back to upload form</a>
	<?php
	if ($user['priv'] >= $apps['image']['index'])
		echo ' - <a href="index-image">back to list of uploaded images</a>';
	?>
	</p>
<?php

require("tpl/general/bottom.php");
