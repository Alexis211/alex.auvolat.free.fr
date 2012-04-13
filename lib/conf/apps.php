<?php

$homepage = "blog";

$apps = array(
	
	// Image upload application
	"image" => array(
		"index" => 1,
		"delete" => 1,
		"editinfo" => 1,
		"upload" => 0,
		"folder" => 0,
		"newfld" => 1,
		"editfld" => 1,
		"delfld" => 1,
	),

	// Account application
	"account" => array(
		"new" => 0,
		"list" => 0,
	),

	// Notebook application
	"notes" => array(
		//"index" => 0,
		"user" => 0,
		"view" => 0,
		"new" => 1,
		"edit" => 1,
		"delete" => 1,
		"move" => 1,
		"source" => 0,
	),

	// Blogging application
	"blog" => array(
		"index" => 0,
		"view" => 0,
		"drafts" => 1,
		"publish" => 1,
		"post" => 1,
		"edit" => 1,
		"delete" => 1,
		"comment" => 1,
		"edcom" => 1,
		"delcom" => 2,
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
	"list" => array(
		"index" => 0,
		"view" => 0,
		"new" => 1,
		"edit" => 1,		// edit global info = name, desc, ...

		"addbatch" => 1,
		"edbatch" => 1,
		"rmbatch" => 1,
	),

	"study" => array (
		"index" => 0,
		"deckadd" => 1,
		"deck" => 1,
		"deckrm" => 1,
		"setrate" => 1,
		"setcard" => 1,

		"listadd" => 1,		// create list_study
		"list" => 1,		// !!!!!! show global progress for a list_study
		"listrm" => 1,		// delete list_study
		"batch" => 1,		// (JS) shows progress for a batch_study
		"batchreview" => 1,	// (JS) batch review app
		"brresults" => 1,
	),

);
