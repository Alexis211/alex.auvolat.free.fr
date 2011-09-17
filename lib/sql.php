<?php

require("conf/sql.php");

$sql_queries = 0;
$sql_connected = false;

function sql_connect() {
	global $sql_server, $sql_user, $sql_password, $sql_database, $sql_connected;
	if ($sql_connected == true) return;
	if (!@mysql_connect($sql_server, $sql_user, $sql_password)) {
		$title = "Cannot connect to SQL server";
		$error = "An error has occurred with the SQL server !";
		require("tpl/general/empty.php");
	}
	mysql_select_db($sql_database);
	mysql_query("SET NAMES 'utf8'");
	$sql_connected = true;
}

function sql($r) {
	global $sql_queries, $sql_connected;
	if ($sql_connected != true) sql_connect();
	$sql_queries++;
	if ($a = mysql_query($r)) {
		return $a;
	} else {
		$title = "SQL error.";
		$request = $r;
		$sql_error = mysql_error();
		require("tpl/general/sqlerror.php");
	}
}

function esca($v) {
	if (get_magic_quotes_gpc()) {
		return stripslashes($v);
	} else {
		return $v;
	}
}
function escs($v) {
	sql_connect();
	return mysql_escape_string($v);
}
function esc($v) {
	return escs(esca($v));
}



