<?php

require("lib/JSON/inc_json.php");
require("lib/list/list_models.php");

function mk_batch_json($models, $contents) {
	global $list_models;

	$data = array("columns" => array(), "items" => array(), "questions" => array());

	if ($models[0] == '*') {
		$model = $list_models[substr($models, 1)];

		$columns = $data['columns'] = $model['columns'];
		$data['questions'] = $model['questions'];
	} else {
		$columns = explode('|', $models);

		foreach ($columns as $k => $c) {
			if ($c[0] == '!') {
				$data['columns'][] = substr($c, 1);
			} else {
				$data['columns'][] = $c;
				$data['questions'][] = array('col' => $k);
			}
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


