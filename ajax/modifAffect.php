<?php
	require "../includes/fonctions.php"; 
	require "../includes/ini.php";
	$bdd->query("DELETE FROM planning_temp WHERE c_id=".$_POST['c_id']." AND m_id=".$_POST['m_id_old']);
	
	if(is_numeric($_POST['m_id_new']))
	{
		$bdd->query("INSERT INTO planning_temp VALUES (".$_POST['c_id'].", ".$_POST['m_id_new'].")");
	}
	else{
		$membres_dispo = $bdd->query("SELECT m_id
			FROM dispos
			WHERE m_id NOT 
			IN (

			SELECT m_id
			FROM planning_temp
			WHERE c_id =".$_POST['c_id']."
			)
			AND c_id =".$_POST['c_id']."
			ORDER BY RAND() 
			LIMIT 1");
		foreach($membres_dispo as $mb)$bdd->query("INSERT INTO planning_temp VALUES (".$_POST['c_id'].", ".$mb['m_id'].")");
	}