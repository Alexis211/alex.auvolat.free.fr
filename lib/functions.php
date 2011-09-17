<?php
if (!function_exists('file_put_contents')) {
	function file_put_contents($filename, $data) {
		$f = @fopen($filename, 'w');
		if (!$f) {
			return false;
		} else {
			$bytes = fwrite($f, $data);
			fclose($f);
			return $bytes;
		}
	}
}

function token_validate($message, $no_url) {
	global $args, $url;
	if (isset($_SESSION['token']) && $_SESSION['token'] == $args[count($args) - 1]) {
		unset($_SESSION['token']);
		return true;
	} else {
		$_SESSION['token'] = md5(time() . rand(0, 100000));
		$title = "Confirmation";
		$choice = array (
			"Yes" => $url . '-' . $_SESSION['token'],
			"No" => $no_url);
		require("tpl/general/choice.php");
	}
}

function token_clear() {
	global $url, $args;
	if (isset($_SESSION['token']) && $_SESSION['token'] != $args[count($args) - 1]) unset($_SESSION['token']);
}

function assert_redir($a, $u) {
	if (!$a) {
		header("Location: $u");
		die();
	}
}

function assert_error($a, $e, $t = "") {
	global $title;
	if (!$a) {
		if (!isset($title) or $t != "") {
			$title = ($t == "" ? "Error" : "Error : $t");
		}
		$error = $e;
		require("tpl/general/empty.php");
		die();
	}
}
