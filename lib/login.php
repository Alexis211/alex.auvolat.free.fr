<?php

require("conf/login.php");

session_start($session_name);

$priv = array(0 => "Anonymous", 1 => "Member", 2 => "Administrator");
$user = array('id' => 0, 'name' => 'Anonymous', 'priv' => 0);

require("sql.php");

if (isset($_GET['logout'])) {
	unset($_SESSION['user_id']);
	unset($_SESSION['user']);
}

if (isset($_POST['login']) && isset($_POST['pw'])) {
	$sql = sql("SELECT id FROM account ".
		"WHERE login = '" . esc($_POST['login']) . "' AND password = PASSWORD('" . esc($_POST['pw']) . "')");
	if ($util = mysql_fetch_assoc($sql)) {
		$_SESSION['user_id'] = intval($util['id']);
	} else {
		$error = "Wrong username or password.";
		$login = $_POST['login'];
		require("tpl/account/login.php");
	}
}

if (isset($_SESSION['user_id'])) {
	if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $_SESSION['user_id']) {
		$user = $_SESSION['user'];
	} else {
		$sql = sql("SELECT login AS name, id, priv ".
			"FROM account ".
			"WHERE id = " . $_SESSION['user_id']);
		if ($util = mysql_fetch_assoc($sql)) {
			$user['id'] = $_SESSION['user_id'];
			$user['name'] = $util['name'];
			$user['priv'] = $util['priv'];
			$_SESSION['user'] = $user;
		} else {
			unset($_SESSION['user_id']);
			unset($_SESSION['user']);
		}
	}
}

if ($user['priv'] < $priv_required) {
	$error = "You must be " . strtolower($priv[$priv_required]) . " to have acces to this page.";
	if ($user['id'] == 0) {
		require("tpl/account/login.php");
	} else {
		require("tpl/general/empty.php");
	}
}

// Si on demande la page de login, ...
if (isset($_GET['login']) && !(isset($_POST['login']) && isset($_POST['pw']))) {
	require ("tpl/account/login.php");
}
