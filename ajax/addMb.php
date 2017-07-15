<?php
	require "../includes/fonctions.php"; 
	require "../includes/ini.php";
	$m = new membre($bdd,0);
	$m->add();
	$m->setName(addslashes($_POST['name']));