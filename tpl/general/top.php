<?php
global $user, $apps;	//These might be hidden because this page is called from sql();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title><?php echo $title; ?></title>
		<link href="design/style.css" rel="stylesheet" type="text/css" media="screen" />
		<?php
		if (isset($js_include)) {
			foreach($js_include as $e) {
				echo '<script type="text/javascript" src="' . $e . '"></script>';
			}
		}
		if (isset($javascript)) echo '<script type="text/javascript">' . $javascript . '</script>';
		?>
	</head>

	<body<?php if (isset($onload_js)) echo ' onload="' . $onload_js . '"'; ?>>

		<div class="menu">
			<div class="right">
			<?php
if ($user['id'] == 0) {
	echo '<a href="new-account">Register</a><a href="?login">Login</a>';
} else {
	echo '<a href="?logout">Logout (' . $user['name'] . ')</a>';
}
?>
			</div>
			<div class="left">
				<a href="blog">Home</a>
				<a href="list-account">People</a>
			<?php
if ($user['id'] != 0) {
	echo '<a href="user-notes-' . $user['id'] . '">notes</a>';
	echo '<a href="file">files</a>';
	echo '<a href="study">studies</a>';
} else {
	if ($user['priv'] >= $apps['file']['upload']) {
		echo '<a href="upload-file">upload file</a>';
	}
	echo '<a href="study">studies</a>';
}
?>
			</div>
			<div style="clear: both;"></div>
		</div>


		<div class="contents-right">

		<h1><?php echo $title; ?></h1>

<?php
if (isset($message)) echo '<div class="message">' . $message . "</div>\n";
if (isset($error)) echo '<div class="error">' . $error . "</div>\n";

