<?php
function tree_branch($tree, $id, $func) {
	if (!isset($tree[$id])) return;
	foreach($tree[$id] as $branch) {
		echo '<p>'.$func($branch).'</p>';
		if (isset($tree[$branch['id']])) {
			echo '<div class="tree_branch">';
			tree_branch($tree, $branch['id'], $func);
			echo '</div>';
		}
	}
}

function tree($tree, $func) {
	echo '<div class="tree_root">';
	tree_branch($tree, 0, $func);
	echo '</div>';
}
