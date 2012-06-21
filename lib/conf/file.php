<?php

$baseurl = "http://localhost/alex.auvolat/files/";
$savedir = getcwd() . "/files/";

$img_mini_width = 127;

function has_mini($ext) {
	return $ext == "jpg" || $ext == "jpeg" || $ext == "png" || $ext == "gif";
}

//$quota = 128;;	//ceil((time() - 1220000000) / (3600 * 24 * 20));
//$min_priv_for_no_quota = 2;
