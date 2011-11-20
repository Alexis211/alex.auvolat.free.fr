<?php

$title = "Testing " . $info['uname'] . ':' . $info['lname'] . ' - ' . $info['bname'];

$javascript = "\n\nconst batchid = " . $info['batchid'] . "\nconst batch_data = " . $info['json_data'] . ";\n\n";
$js_include = array("js/prototype.js", "js/reviewdesu.js");
$onload_js = 'start_review();';

require("tpl/general/top.php");

echo '<div id="core">Please wait, processing...</div>';

require("tpl/general/bottom.php");
