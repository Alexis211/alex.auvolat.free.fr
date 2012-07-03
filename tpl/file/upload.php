<?php
$title = "Upload a file";

if ($user['id'] == 0) $message = "You should create an account so that you can track files you have uploaded.";

$form_message = "If you upload an image, a $img_mini_width"."px preview will be created.";
$need_file = true;
$fields = array(
	array("label" => "File : ", "type" => "file", "name" => "file"),
	array("label" => "Filename (optionnal) : ", "type" => "text", "name" => "name")
	);
$validate = "Upload";

require("tpl/general/form.php");


