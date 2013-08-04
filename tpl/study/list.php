<?php

$title = "Studying " . $study['listowner'] . ':' . $study['listname'];
require("tpl/general/top.php");

echo '<div class="small_right"><a href="listrm-study-' . $studyid . '">stop studying</a></div>';

echo '<div class="ordering_links">' . filters_html_full() . '</div>';

echo '<table><tr><th>Batch name</th><th>actions</th><th>last test</th><th>score</th></tr>';
foreach ($batches as $batch) {
	$color = "";
	if ($batch['lr_date']) {
		if ($batch['lr_score'] == 100)
			$color = "#00AA00";
		else if ($batch['lr_score'] >= 80)
			$color = "#55FF55";
		else if ($batch['lr_score'] >= 50)
			$color = "#FFFF00";
		else
			$color = "#FF7777";

	}
	if ($color != "") $color = ' style="background-color: ' . $color . '"';


	echo '<tr>';
	echo '<td><code>' . $batch['name'] . '</code></td>';
	echo '<td><a href="batch-study-' . $batch['id'] . '">view</a> | <a href="batchreview-study-' . $batch['id'] . '">test</a></td>';
	echo '<td>' . ($batch['lr_date'] ? $batch['lr_date'] : "never") . '</td>';
	echo '<td'.$color.'>' . ($batch['lr_date'] ? $batch['lr_score'] . '/100' : 'N/A') . '</td>';
	echo '</tr>';
}
echo '</table>';

require("lib_sidebar.php");
require("tpl/general/bottom.php");
