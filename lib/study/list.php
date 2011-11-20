<?php

assert_redir(count($args) == 3, 'study');
$studyid = intval($args[2]);

$study = mysql_fetch_assoc(sql(
	"SELECT lists.id AS listid, lists.name AS listname, account.login AS listowner, ".
	" list_study.user AS learn_user ".
	"FROM list_study LEFT JOIN lists ON list_study.list = lists.id LEFT JOIN account ON account.id = lists.owner ".
	"WHERE list_study.id = $studyid"));
assert_error($study && $study['learn_user'] == $user['id'], "You are not at the right place here.");

$filters = array(
	"order" => array(
		"name" => "name",
		"lr_score" => "last score"
	),
	"way" => $ord_ways,
);
$fdefaults = array(
	"order" => "name",
	"way" => "ASC",
);

$batches = array();
$n = sql(
	"SELECT batches.id AS id, batches.name AS name, ".
	"batch_study.id AS bs_id, batch_review.date AS lr_date, batch_review.score AS lr_score ".
	"FROM batches ".
	"LEFT JOIN batch_study ON batch_study.batch = batches.id AND batch_study.user = " . $user['id'] . " " .
	"LEFT JOIN batch_review ON batch_review.id = batch_study.last_review ".
	"WHERE batches.list = " . $study['listid'] . " " .
	"ORDER BY " . get_filter("order") . " " . get_filter("way")
	);
while ($b = mysql_fetch_assoc($n)) $batches[] = $b;

require("tpl/study/list.php");
