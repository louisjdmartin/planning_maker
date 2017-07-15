<?php
	require "../includes/fonctions.php"; 
	require "../includes/ini.php";
	$m = new membre($bdd,addslashes($_POST['id']));
	$m->del();