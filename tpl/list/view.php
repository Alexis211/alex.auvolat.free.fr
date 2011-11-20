<?php

$title = $list['owner'] . ':' . $list['name'];
require("tpl/general/top.php");

if ($can_edit) {
	echo '<div class="small_right"><a href="edit-list-' . $list['id'] . '">edit</a> | ';
	echo '<a href="addbatch-list-' . $list['id'] . '">add batch</a></div>';
}

echo $list['comment'];

if ($can_start_study) {
	echo '<p style="text-align: center; font-size: 1.2em;"><a href="listadd-study-' . $listid . '">&gt;&gt; start studying this list &lt;&lt;</a></p>';
}

echo '<table><tr><th>Batch name</th>' . ($can_edit ? '<th>actions</th>' : '') . '</tr>';
foreach ($batches as $batch) {
	echo '<tr><td>' . $batch['name'] . '</td>';
	if ($can_edit) {
		echo '<td><a href="edbatch-list-' . $batch['id'] . '">edit</a> | <a href="rmbatch-list-' . $batch['id'] . '">remove</a></td>';
	}
	echo '</tr>';
}
echo '</table>';

require("tpl/study/lib_sidebar.php");

require("tpl/general/bottom.php");
