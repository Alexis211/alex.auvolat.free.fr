<?php

$homepage = "notes";

$apps = array(
	
	// Image upload application
	"image" => array(
		"index" => 1,
		"delete" => 1,
		"upload" => 0,
	),

	// Account application
	"account" => array(
		"new" => 0,
	),

	// Notebook application
	"notes" => array(
		"index" => 0,
		"user" => 0,
		"view" => 0,
		"new" => 1,
		"edit" => 1,
		"delete" => 1,
		"move" => 1,
		"source" => 0,
	),

	// Studies application
	"deck" => array(
		"index" => 0,
		"new" => 1,
		"view" => 0,
		// function called for editing
		"edit" => 1,		// change title, comment
		"addent" => 1,		// add card
		"rment" => 1,		// remove card
		"edent" => 1,		// edit card
		"mvent" => 1,		// move card
	),
	"study" => array (
		"index" => 1,
		"deckadd" => 1,
		"deck" => 1,
	),

);
