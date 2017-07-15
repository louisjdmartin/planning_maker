<?php
	require "../includes/fonctions.php"; 
	require "../includes/ini.php";
	$moi->setDispo($_POST['c_id'], $_POST['dispo']);
	unlink(dirname(__FILE__) ."/../phpfiles/last_genere");