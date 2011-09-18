<?php

$title = "Studying " . $study['deckowner'] . ':' . $study['deckname'];
require("tpl/general/top.php");

echo '<div class="small_right"><a href="deckrm-study-' . $studyid . '">stop studying</a> | <a href="view-deck-' . $study['deckid'] . '">view whole deck</a></div>';

echo '<div style="margin-top: 20px;text-align: center; font-size: 1.2em;">';
echo 'Load : ' . $load . '/' . $study['learn_rate'] . ' - <a href="setrate-study-' . $studyid . '">change study rate</a></div>';

if (isset($next_card)) {
	if ($next_card) {
		echo '<div class="study_card">';
		echo '<div class="small_right"><a href="setcard-study-'.$next_card['id'].'-0">skip this card (0)</a><br />';
		echo '<a href="setcard-study-'.$next_card['id'].'-1">learn this card (1)</a><br />';
		echo '<a href="setcard-study-'.$next_card['id'].'-4">I know this already (4)</a><br />';
		echo '<a href="setcard-study-'.$next_card['id'].'-7">I totally know this already (7)</a></div>';
		echo '<code style="font-weight: bold">(next card) #'.$next_card['number'].': '.$next_card['name'].'</code>';
		echo $next_card['text_html'];
		echo '<div style="clear: both"></div></div>';
	} else {
		echo '<p>No more cards to study !</p>';
	}
}

echo '<div class="ordering_links">' . filters_html_full() . '</div>';

if (count($study_cards) == 0) {
	echo '<p>Nothing in this list at the moment.</p>';
} else {
	foreach($study_cards as $card) {
		echo '<div class="study_card scb'.$card['level'].'">';

		$l = array();
		if ($card['level'] > 0) {
			$l[] = '<a href="setcard-study-'.$card['id'].'-0">'. ($card['level'] >= 4 ? 'put in skip list' : 'skip this card') . '</a>';
		}
		if ($card['must_study'] || $card['level'] == 0 || $card['level'] == 7) {
			$l[] = '<a href="setcard-study-'.$card['id'].'-1">'. ($card['level'] == 0 ? 'learn this card' : 'I forgot all about this'). ' (1)</a>';
			if ($card['level'] > 0 and $card['level'] < 3) {
				$l[] = '<a href="setcard-study-'.$card['id'].'-'.($card['level']+1).'" style="font-weight: bold">I\'m learning this ('.($card['level']+1).')</a>';
			}
			if ($card['level'] < 4) {
				$l[] = '<a href="setcard-study-'.$card['id'].'-4"'.
				($card['level'] == 3 ? ' style="font-weight: bold"' : '')
				.'>I know this (4)</a>';
			}
			if ($card['level'] > 3 and $card['level'] < 6) {
				$l[] = '<a href="setcard-study-'.$card['id'].'-'.($card['level']+1).'" style="font-weight: bold">I know this ('.($card['level']+1).')</a>';
			}
		}
		if ($card['level'] < 7) {
			$l[] = '<a href="setcard-study-'.$card['id'].'-7"' .
				($card['level'] == 6 && $card['must_study'] ? ' style="font-weight: bold"' : '')
				.'>I totally know this (7)</a>';
		}
		echo '<div class="small_right">';
		echo implode("<br />\n", $l);
		echo '</div>';

		echo '<code' . ($card['must_study'] ? ' style="font-weight: bold"' : '') . '>(' . ($card['level'] == 0 ? 'skipped' : 'level '.$card['level']) .') #'.$card['number'].': '.$card['name'].'</code>';
		echo $card['text'];
		echo '<div style="clear: both"></div></div>';
	}
}

require ("lib_sidebar.php");
require("tpl/general/bottom.php");
