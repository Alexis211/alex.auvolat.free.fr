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


// **** DISPLAY FILTERS *******

function get_filter($name) {
	global $filters, $fdefaults;
	if (!isset($filters[$name])) return "";
	$v = (isset($_GET[$name]) ? $_GET[$name] : "");
	if (!isset($filters[$name][$v])) return $fdefaults[$name];
	return $v;
}

function filter_html_entry($name, $entry) {
	global $filters, $filters_defaults, $url;
	if (!isset($filters[$name])) return "";
	if (!isset($filters[$name][$entry])) return "";
	$rurl = array("p=".$url, $name . "=" . $entry);
	foreach ($filters as $filter => $n) {
		if ($filter != $name) {
			$rurl[] = ($filter . "=" . get_filter($filter));
		}
	}
	return '<a href="index.php?' . implode("&", $rurl) . '">' . $filters[$name][$entry] . '</a>';
}

function filter_html($name) {
	global $filters, $filters_defaults;
	if (!isset($filters[$name])) return "";
	$r = array();
	foreach ($filters[$name] as $v => $t) {
		if (get_filter($name) == $v) {
			$r[] = "<b>" . $t . "</b>";
		} else {
			$r[] = filter_html_entry($name, $v);
		}
	}
	return implode(", ", $r);
}

function filters_html() {
	global $filters;
	$r = array();
	foreach ($filters as $k => $filter) {
		$r[$k] = filter_html($k);
	}
	return $r;
}

function filters_html_full() {
	global $filters_names;
	$r = array();
	foreach (filters_html() as $f => $h) {
		$r[] = $f . " (" . $h . ")";
	} 
	return implode(", ", $r);
}

$ord_ways = array (
	"ASC" => "ascending",
	"DESC" => "descending"
);
