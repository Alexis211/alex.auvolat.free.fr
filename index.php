<?php
header("HTTP/1.1 200 OK");
require("lib/conf/apps.php");
require("lib/functions.php");

if (isset($_GET["p"])) {
	$args = $_GET['p'];
} else {
	$args = explode('/', $_SERVER['REQUEST_URI']);
	$args = $args[count($args) - 1];
	$args = explode('?', $args);
	if (count($args) == 2) $_GET[$args[1]] = 0;
	$args = $args[0];
	if ($args == "" or $args == "index.php") $args = $homepage;
}
$args = explode('-', $args);
if (count($args) == 1) $args = array("index", $args[0]);
$url = implode('-', $args);
token_clear();

if (isset($apps[$args[1]])) {
	if (isset($apps[$args[1]][$args[0]])) {
		$priv_required = $apps[$args[1]][$args[0]];
		require("lib/login.php");
		token_clear();
		require("lib/" . $args[1] . "/" . $args[0] . ".php");
	}
}

$title = "Not found";
$error = "This page does not exist.";
require("tpl/general/empty.php");
