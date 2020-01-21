<?php
	require "../includes/fonctions.php";
	require "../includes/ini.php";
	$bdd->query("TRUNCATE TABLE planning_last");
	$p=$bdd->query("SELECT * FROM planning_def");
	foreach ($p as $s)
	{
		$bdd->query("INSERT INTO planning_last VALUES (".$s['c_id'].", ".$s['m_id'].")");
	}


	$bdd->query("TRUNCATE TABLE planning_def");
	$p=$bdd->query("SELECT * FROM planning_temp");
	foreach ($p as $s)
	{
		$bdd->query("INSERT INTO planning_def VALUES (".$s['c_id'].", ".$s['m_id'].")");
	}
	$bdd->query("TRUNCATE TABLE absences");
	header("location:../?page=definitif");
