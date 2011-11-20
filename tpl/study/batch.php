<?php

$title = $info['uname'] . ':' . $info['lname'] . ' - ' . $info['bname'];

$javascript = "\n\nconst batch_data = " . $info['json_data'] . ";\n\nconst reviews_data =  $reviews;\n\n";
$js_include = array("js/prototype.js", "js/liststudy.js");
$onload_js = 'show_batch_table();';

require("tpl/general/top.php");

echo '<div class="small_right"><a href="batchreview-study-' . $info['batchid'] . '">test now</a></div>';

echo '<h2>Items in this list</h2>';
echo '<div id="items">Please wait, processing...</div>';
echo '<h2>Reviews</h2>';
echo '<div id="reviews">Please wait, processing...</div>';

require("tpl/study/lib_sidebar.php");
require("tpl/general/bottom.php");

