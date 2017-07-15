<?php 
	$membres = $bdd->query("SELECT * FROM  `membres` ORDER BY m_nom");
	foreach($membres as $m){
		
		echo "<a href='./?choix=".$m['m_id']."'>".$m['m_nom']."</a> <br /><br /> ";
		
	}
?>