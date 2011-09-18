<?php

$title = "My studies";
require("tpl/general/top.php");

?>

<p>Welcome to the <em>My studies</em> section. This is a simple study program based on
decks of cards, keeping track of your progress and everything.</p>

<p>Please take a look in the <a href="deck">List of decks</a> and start learning whatever you want to learn.</p>

<p>The cards you are studying are classified in the following <em>boxes</em> :</p>
<ul>
<li><strong>Skipped cards :</strong> cards you can't really say you know, but you don't want to study right now.</li>
<li><strong>Levels 1 to 3 :</strong> you are reviewing these cards daily (or almost), in order to <em>learn</em> them.</li>
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
  you to learn.</p>

<?php

require ("lib_sidebar.php");
require("tpl/general/bottom.php");
