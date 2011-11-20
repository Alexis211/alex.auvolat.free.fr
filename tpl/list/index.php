<?php

$title = "Study lists";

if ($user['id'] == 0) $message = "Hey, you should create an account so that you can study with us!";

require("tpl/general/top.php");

echo '<div class="ordering_links">' . filters_html_full() . '</div>';

echo "<table><tr><th>Name</th><th>Users</th>";
foreach ($lists as $list) {
	echo '<tr><td><code>' . $list["owner"] . ':<a href="view-list-' . $list['id'] . '">' . $list["name"] . '</a></code></td>';
	echo '<td>' . $list["nbUsers"] . '</td></tr>';
}
echo "</table>";

require("tpl/study/lib_sidebar.php");

require("tpl/general/bottom.php");
