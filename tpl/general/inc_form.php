<?php


if (!isset($method)) $method = "POST";
if (!isset($validate)) $validate = "Post";
if (!isset($action)) $action = "index.php?p=$url";

echo '<form method="' . $method . '" action="' . $action . '"' .
   	(isset($need_file) ? ' enctype="multipart/form-data"' : '') . '>';
if (isset($form_message)) echo '<strong>' . $form_message . "</strong><br /><br />\n";

foreach($fields as $f) {
	if (isset($f['type']) && $f['type'] == 'textarea') {
		echo '<label>' . $f['label'] . '</label><br />';
		echo '<textarea name="' . $f['name'] . '">' . $f['value'] . '</textarea><br />';
	} else if (isset($f['type']) && $f['type'] == 'select') {
		echo '<label>' . $f['label'] . '</label>';
		echo '<select name="' . $f['name'] . '">';
		foreach ($f['choices'] as $id => $text) {
			echo '<option value="' . $id . '"'. ($id == $f['value'] ? ' selected="selected"' : '') .
				'>' . $text . '</option>';
		}
		echo '</select><br />';
	} else {
?>
<label for="ff_<?php echo $f['name']; ?>"><?php echo $f['label']; ?></label>
<input type="<?php echo (isset($f['type']) ? $f['type'] : 'text'); ?>" name="<?php echo $f['name']; ?>" <?php
if (isset($f['value'])) echo ' value="' . $f['value'] . '"' ;
if (isset($f['checked']) && $f['checked'] == true) echo ' checked="checked"';
?> id="ff_<?php echo $f['name']; ?>"/><br /><?php
	}
}

echo '<div class="empty_label">&nbsp;</div><input type="submit" value="' . $validate . '" /></form>';
