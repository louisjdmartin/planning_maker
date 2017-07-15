<?php
	ini_set("display_errors","1");
	require "../includes/fonctions.php"; 
	require "../includes/ini.php";
	$c = new creneau($bdd,addslashes($_POST['id']));
	$c->modif(addslashes($_POST['c_deb']),addslashes($_POST['c_fin']),addslashes($_POST['c_jour']),addslashes($_POST['c_poids']),addslashes($_POST['affectations']));