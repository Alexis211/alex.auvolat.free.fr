<?php

$list_models = array(
	"RTK-Kanji" => array(
		"columns" => array("N#", "Kanji", "Keyword", "Strokes"),
		"questions" => array(
			array(
				'q' => '<p class="rtk_kr_q_2">%2</p>',
				'a' => '<p class="rtk_kr_a_2">#%0: %2 [%3]<br /><span>%1</span></p>'
			),
			array(
				'q' => '<p class="rtk_kr_q_1">%1</p>',
				'a' => '<p class="rtk_kr_a_1">#%0: %1 [%3]<br /><span>%2</span></p>'
			),
		),
	),
	"JA-Vocab" => array(
		"columns" => array("N#", "Kanji", "Kana", "English"),
		"questions" => array(
			array(
				'q' => '<p class="rtk_kr_q_2">%3</p>',
				'a' => '<p class="rtk_kr_a_2">%2<br /><span>%1</span><br />%3</p>',
			),
			array(
				'q' => '<p class="rtk_kr_q_1">%1</p>',
				'a' => '<p class="rtk_kr_a_1">%1　【%2】<br /><span>%3</span></p>',
			),
		),
	),
);
