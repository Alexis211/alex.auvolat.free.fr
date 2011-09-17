<?php
$title = "Login";

$form_message = "Please log in with your account :";
$fields = array(
  array ("label" => "Username : ", "name" => "login", "value" => (isset($login) ? $login : '')),
  array ("label" => "Password : ", "name" => "pw", "type" => "password"));
$validate = "Log in";

require("tpl/general/form.php");
