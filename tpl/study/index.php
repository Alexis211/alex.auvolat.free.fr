<?php

$title = "Studies";
require("tpl/general/top.php");

?>

<p>Welcome to the <em>studies</em> section. This is a simple study program, with two methods of studying available.</p>

<h3>First method : cards</h3>
<p>The first method is based on
decks of cards, keeping track of your progress and everything.</p>

<p>The cards you are studying are classified in the following <em>boxes</em> :</p>
<ul>
<li><strong>Skipped cards :</strong> cards you can't really say you know, but you don't want to study right now.</li>
<li><strong>Levels 1 to 3 :</strong> you are reviewing these cards frequently, in order to <em>learn</em> them.</li>
<li><strong>Level 4 to 6 :</strong> we consider you <em>know</em> that card, and you are just reviewing it from times to times,
  making sure you didn't forget it.</li>
<li><strong>Level 7 :</strong> you totally know that card and will never be asked about it again.</li>
</ul>
<p>You can freely move cards into different boxes using the links that appear at the right of the card, the number in the parenthesis being
  the level that card will have if you click it.
Cards you are supposed to study or review today appear with a bold title : that means that <em>today</em>,
  you should decide to put it either in the next box, or somewhere else.</p>
<p>The <em>load</em> is calculated as a function of the number of cards with levels from 1 to 3 : it represents the quantity of
  stuff you are <em>learning</em> right now. When the load is smaller than the study rate you ask for, new cards will be suggested for
  you to learn (if any are available in the deck).</p>

<p>Please take a look at the <a href="deck">list of decks</a> and start learning whatever you want to learn.
You can also create your own decks, the editor is pretty intuitive.</p>

<h3>Second method : study lists</h3>
<p>In this method, we have lists of stuff to learn (like vocabulary), divided into batches (the batches are sorted
for a given list). You will study one batch at a time, and take a test for one batch at a time. All your test results
	are kept in storage and are used to display your progress.</p>

<p>Please take a look at the <a href="list">list of lists</a> and start learning whatever you want to learn.</p>

<?php

require ("lib_sidebar.php");
require("tpl/general/bottom.php");
