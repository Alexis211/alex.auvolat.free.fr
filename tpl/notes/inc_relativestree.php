<?php

/* OLD WAY

// ******* FETCH DATA

if ($note['parent_id'] != 0) {
	$brothers = array();
	$n = sql("SELECT id, title, owner FROM notes WHERE parent = " . $note['parent_id'] . " ".
		($note['owner'] == $user['id'] ? "" : " AND public != 0 ").
		"ORDER BY title ASC");
	while ($nn = mysql_fetch_assoc($n)) $brothers[] = $nn;
}
$children = array();
$n = sql("SELECT id, title, owner FROM notes WHERE parent = " . $note['id'] . " " .
	($note['owner'] == $user['id'] ? "" : " AND public != 0 ") .
	"ORDER BY title ASC");
while ($nn = mysql_fetch_assoc($n)) $children[] = $nn;

$user_root_notes = array();
$n = sql("SELECT id, title, owner FROM notes WHERE parent = 0 AND owner = " . $note['owner'] . " " .
	($note['owner'] == $user['id'] ? "" : " AND public != 0 ") .
	"ORDER BY title ASC");
while ($nn = mysql_fetch_assoc($n)) $user_root_notes[] = $nn;

// ****** DISPLAY TREE

echo '</div><div class="contents-left">';
echo '<h1>' . $note['ownername'] . '</h1><br />';
echo '<div class="small_right"><a href="user-notes-' . $note['owner'] . '">complete tree</a></div>';

function list_brothers_and_children() {
	global $brothers, $children, $note, $user, $can_new;
	echo '<div class="tree_branch">';
	foreach($brothers as $b) {
		if ($b['id'] == $note['id']) {
			echo '<p>' . $b['title'] . '</p><div class="tree_branch">';
			foreach($children as $nn) {
				echo '<p><a href="view-notes-' . $nn['id'] . '">' . $nn['title'] . '</a></p>';
			}
			if ($can_new) {
				echo '<p><a class="tool_link" href="new-notes-' . $b['id'] . '">+ new note</a></p>';
			}
			echo '</div>';
		} else {
			echo '<p><a href="view-notes-' . $b['id'] .'">' . $b['title'] . '</a></p>';
		}
	}
	if ($can_new) {
		echo '<p><a class="tool_link" href="new-notes-' . $note['parent_id'] . '">+ new note</a></p>';
	}
	echo '</div>';
}

echo '<div class="tree_branch">';
$did_show_up = false;
foreach($user_root_notes as $n) {
	if ($n['id'] == $note['id']) {
		$did_show_up = true;
		echo '<p>' . $n['title'] . '</p><div class="tree_branch">';
		foreach($children as $nn) {
			echo '<p><a href="view-notes-' . $nn['id'] . '">' . $nn['title'] . '</a></p>';
		}
		if ($can_new) {
			echo '<p><a class="tool_link" href="new-notes-' . $note['id'] . '">+ new note</a></p>';
		}
		echo '</div>';
	} else {
		echo '<p><a href="view-notes-' . $n['id'] . '">' . $n['title'] . '</a></p>';
		if ($n['id'] == $note['parent_id']) {
			$did_show_up = true;
			list_brothers_and_children();
		}
	}
}
if ($can_new) {
	echo '<p><a class="tool_link" href="new-notes-0">+ new note</a></p>';
}
echo '</div>';

if (!$did_show_up) {
	echo '<br /><br />';
	echo '<a href="view-notes-' . $note['parent_id'] . '">' . $note['parent_title'] . '</a>';
	list_brothers_and_children();
}

*/

// *** NEW WAY

$notes_tree = array();
$notes_parents = array();
$n = sql("SELECT id, parent, title FROM notes ".
	"WHERE owner = " . $note['owner'] .
	($note['owner'] == $user['id'] ? " " : " AND public != 0 ") .
	"ORDER BY title ASC");
while ($nn = mysql_fetch_assoc($n)) {
	$notes_parents[$nn['id']] = $nn['parent'];
	if (isset($notes_tree[$nn['parent']])) {
		$notes_tree[$nn['parent']][] = $nn;
	} else {
		$notes_tree[$nn['parent']] = array($nn);
	}
}

$notest = array(0 => @$notes_tree[0]);
for($id = $note['id']; $id != 0; $id = $notes_parents[$id]) {
	$notest[$id] = @$notes_tree[$id];
}

echo '</div><div class="contents-left">';
echo '<h1>' . $note['ownername'] . '</h1><br />';
echo '<div class="small_right"><a href="user-notes-' . $note['owner'] . '">complete tree</a></div>';

function n_tree_branch($id) {
	global $notest, $note, $can_new;
	if (!isset($notest[$id])) return;
	foreach($notest[$id] as $branch) {
		if ($branch['id'] == $note['id'])
			echo '<p>' . $branch['title'] . '</p>';
		else
			echo '<p><a href="view-notes-' . $branch['id'] . '">' . $branch['title'] . '</a></p>';
		if (isset($notest[$branch['id']])) {
			echo '<div class="tree_branch">';
			n_tree_branch($branch['id']);
			echo '</div>';
		} else if ($can_new && $branch['id'] == $note['id']) {
			echo '<div class="tree_branch">';
			if ($can_new) echo '<p><a class="tool_link" href="new-notes-' . $branch['id'] . '">+ new note</a></p>';
			echo '</div>';
		}
	}
	if ($can_new) echo '<p><a class="tool_link" href="new-notes-' . $id . '">+ new note</a></p>';
}

echo '<div class="tree_root">';
n_tree_branch(0);
echo '</div>';

