<?php
	ini_set("display_errors","1");
	require "../includes/fonctions.php"; 
	require "../includes/ini.php";
	$c = new creneau($bdd,addslashes($_POST['id']));
	$c->del();