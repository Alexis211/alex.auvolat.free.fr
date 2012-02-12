<?php

$title = "Upload an image";

require("lib/conf/image.php");

/*
$number = mysql_fetch_assoc(sql("SELECT count(*) AS count FROM images WHERE owner = " . $user['id']));
assert_error($number['count'] < $quota || $user['priv'] >= $min_priv_for_no_quota || $user['id'] == 0,
	"You have already exceeded your upload quota.");
*/

if (isset($_FILES['image']) && isset($_POST['name'])) {
	$name = esca($_POST['name']);
	if ($name == "") $name = $_FILES['image']['name'];
	if ($_FILES['image']['error'] != 0) {
		$error = "Sorry, an error occurred while uploading your file. Try with a smaller one.";
		require("tpl/image/upload.php");
	}
	$origname = strtolower(basename($_FILES['image']['name']));
	if (preg_match("#\.png$#",$origname)) {
		$type = "png";
	} elseif (preg_match("#\.gif$#",$origname)) {
		$type = "gif";
	} elseif (preg_match("#\.jpg$#",$origname) or preg_match("#\.jpeg$#",$origname)) {
		$type = "jpg";
	} else {
		$error = "Sorry, we only accept GIF, PNG and JPEG images.";
		require("tpl/image/upload.php");
	}
	sql("INSERT INTO images(owner, extension, name, upl_date) VALUES(" . $user['id'] . ", '$type', '" . escs($name) . "', NOW())");
	$id = mysql_insert_id();
	$filen = $savedir . $id . "." . $type;
	$minin = $savedir . $id . "-min." . $type;
	if (!copy($_FILES['image']['tmp_name'], $filen)) {
		$error = "An internal error occurred. You might want to try again later.";
		sql("DELETE FROM images WHERE id = $id");
		require("tpl/image/upload.php");
	}

	if ($type == "png")
		$source = imagecreatefrompng($filen); 
	elseif ($type == "jpg")
		$source = imagecreatefromjpeg($filen);
	elseif ($type == "gif")
		$source = imagecreatefromgif($filen);
	$l = imagesx($source);
	$h = imagesy($source);
	$l2 = $miniature_width;
	$h2 = $l2 * $h / $l;
	$mini = imagecreatetruecolor($l2, $h2);
	imagecopyresampled($mini, $source, 0, 0, 0, 0, $l2, $h2, $l, $h);
	if ($type == "png")
		imagepng($mini, $minin);
	elseif ($type == "jpg")
		imagejpeg($mini, $minin);
	elseif ($type == "gif")
		imagegif($mini, $minin);
	$message = "Your image has been uploaded successfully.";
	require("tpl/image/upload-ok.php");
} else {
	require("tpl/image/upload.php");
}
