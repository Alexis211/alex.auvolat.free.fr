<?php

$title = "Register";

$login = "";
$email = "";
if (isset($_POST['login']) && isset($_POST['pw1']) && isset($_POST['pw2'])) {
	$login = esca($_POST["login"]);
	$email = esca($_POST["email"]);
	$pw1 = esc($_POST["pw1"]);
	$pw2 = esc($_POST["pw2"]);
	if ($login == "") {
		$error = "You must enter a username.";
	} else if (!preg_match('#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#', $email)) {
		$error = "You must enter a valid email address.";
	} else if ($pw1 != $pw2) {
		$error = "You must enter twice the same password.";
	} else if ($pw1 == "") {
		$error = "You must enter a password";
	} else {
		sql("INSERT INTO account(login, password, email, reg_date) ".
			"VALUES('" . escs($login) . "', PASSWORD('$pw1'), '" . escs($email) . "', NOW())");
		$message = "Your account has been created. Please log in now.";
		$url = $homepage;
		require("tpl/account/login.php");
	}
}

$form_message = "Please fill in the following form to create an account :";
$fields = array(
	array("label" => "Username : ", "name" => "login", "value" => $login),
	array("label" => "Password : ", "name" => "pw1", "type" => "password"),
	array("label" => "Confirm password : ", "name" => "pw2", "type" => "password"),
	array("label" => "Email address : ", "name" => "email", "value" => $email)
	);
$validate = "Create an account";

require("tpl/general/form.php");
