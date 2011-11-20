<?php

require("lib/JSON/inc_json.php");

function mk_batch_json($models, $contents) {
	$data = array("columns" => array(), "items" => array());

	$columns = explode('|', $models);
	foreach ($columns as $c) {
		if ($c[0] == '!') {
			$data['columns'][] = array("question" => false, "name" => substr($c, 1));
		} else {
			$data['columns'][] = array("question" => true, "name" => $c);
		}
	}

	$items = explode("\n", $contents);
	foreach($items as $i) {
		$ii = explode('|', str_replace("\r", '', $i));
		if (count($ii) == count($columns)) {
			$data['items'][] = $ii;
		}
	}

	return json_encode($data);
}


