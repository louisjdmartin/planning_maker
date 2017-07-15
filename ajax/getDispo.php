<?php
	require "../includes/fonctions.php"; 
	require "../includes/ini.php";
	$membres_dispo = $bdd->query("SELECT * FROM dispos,membres WHERE c_id=".$_POST['c_id']." AND dispos.m_id=membres.m_id ORDER BY membres.m_nom");
	foreach($membres_dispo as $m){
		echo "<option value='".$m['m_id']."'>".$m['m_nom']."</option>";
	}
	echo "<option value='rand'>au hasard</option>";