<?php

$title = "Upload a file";

require("lib/conf/file.php");


if (isset($_FILES['file']) && isset($_POST['name'])) {
	$name = esca($_POST['name']);
	if ($name == "") $name = $_FILES['file']['name'];
	if ($_FILES['file']['error'] != 0) {
		$error = "Sorry, an error occurred while uploading your file. Try with a smaller one.";
		require("tpl/file/upload.php");
	}
	$origname = strtolower(basename($_FILES['file']['name']));
	$type = preg_replace("#^.+\.([a-z0-9]+)$#", "$1", $origname);

	sql("INSERT INTO files(owner, extension, name, upl_date) VALUES(" . $user['id'] . ", '$type', '" . escs($name) . "', NOW())");
	$id = mysql_insert_id();
	$filen = $savedir . $id . "." . $type;
	if (!copy($_FILES['file']['tmp_name'], $filen)) {
		$error = "An internal error occurred. You might want to try again later.";
		sql("DELETE FROM files WHERE id = $id");
		require("tpl/file/upload.php");
	}

	if (has_mini($type)) {
		$minin = $savedir . $id . "-min." . $type;
		if ($type == "png")
			$source = imagecreatefrompng($filen); 
		elseif ($type == "jpg" || $type == "jpeg")
			$source = imagecreatefromjpeg($filen);
		elseif ($type == "gif")
			$source = imagecreatefromgif($filen);
		$l = imagesx($source);
		$h = imagesy($source);
		$l2 = $img_mini_width;
		$h2 = $l2 * $h / $l;
		$mini = imagecreatetruecolor($l2, $h2);
		imagecopyresampled($mini, $source, 0, 0, 0, 0, $l2, $h2, $l, $h);
		if ($type == "png")
			imagepng($mini, $minin);
		elseif ($type == "jpg")
			imagejpeg($mini, $minin);
		elseif ($type == "gif")
			imagegif($mini, $minin);
		$message = "Your image has been uploaded successfully and a miniature has been created.";
	} else {
		$message = "Your file has been uploaded successfully.";
	}
	require("tpl/file/upload-ok.php");
} else {
	require("tpl/file/upload.php");
}
