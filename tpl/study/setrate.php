<?php

$title = "Change learn rate for " . $study['deckowner'] . ':' . $study['deckname'];
require("tpl/general/top.php");

echo '<p><strong>Current learn rate :</strong> ' . $study['learn_rate'] . ' - <a href="deck-study-' . $studyid . '">keep this rate</a></p>';

echo '<p>Please choose how much you intend on studying :</p><ul>';
echo '<li><a href="setrate-study-' . $studyid . '-5">Just a tiny bit (5)</a></li>';
echo '<li><a href="setrate-study-' . $studyid . '-10">A little (10)</a></li>';
echo '<li><a href="setrate-study-' . $studyid . '-15">Some (15)</a></li>';
echo '<li><a href="setrate-study-' . $studyid . '-20">A lot (20)</a></li>';
echo '<li><a href="setrate-study-' . $studyid . '-30">A real lot (30)</a></li>';
echo '<li><a href="#" onclick="if (rate = prompt(\'Desired learn rate :\', 10)) { window.location = \'setrate-study-' . $studyid . '-\' + rate; }">Custom</a></li>';
echo '</ul>';

require ("lib_sidebar.php");
require("tpl/general/bottom.php");
