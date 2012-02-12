<?php
$title = "Upload an image";

if ($user['id'] == 0) $message = "You should create an account so that you can track images you have uploaded.";

$form_message = "A $miniature_width"."px preview will be created.";
$need_file = true;
$fields = array(
	array("label" => "Image file : ", "type" => "file", "name" => "image"),
	array("label" => "Image title (optionnal) : ", "type" => "text", "name" => "name")
	);
$validate = "Upload";

require("tpl/general/form.php");


