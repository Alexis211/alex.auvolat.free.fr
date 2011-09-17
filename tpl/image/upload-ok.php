<?php
require("tpl/general/top.php");

$minurl = $baseurl . $id . "-min." . $type;
$imgurl = $baseurl . $id . "." . $type;

?>
	Preview : <a href="<?php echo $minurl; ?>"><?php echo $minurl; ?></a><br />
	Image : <a href="<?php echo $imgurl; ?>"><?php echo $imgurl; ?></a><br />
<?php

require("tpl/general/bottom.php");
