<script>
	function valide(){
		$('#fct_genere').html("<form action='ajax/valide.php' method='POST'><input type='submit' value='Confirmer' /></form>");
		$('#mdp').focus();
	}
</script>
<table>
	<tr>
		<td id='fct_genere'>Fonctions: <br />
			<a href="ajax/regenere.php">Regenerer</a>
			<a onclick='valide()'>Valider</a>
		</td>
	</tr>
</table><div style='clear:both'></div>
<?php
	if(!file_exists (dirname(__FILE__) ."/../phpfiles/last_genere"))genere_planning($bdd);;


	affichePlanning("temp", $moi);

	$membres = $bdd->query("SELECT * FROM membres ORDER BY m_nom");
	echo "<table><tr><th><strong>Compteur de perms</strong></th></tr>";
	foreach($membres as $mb){
		$membre = new membre($bdd, $mb['m_id']);
		$membre->actualiseTempsPerm("temp");
		echo "<tr><td>".$membre->getNom()." ";
		$membre->affichePerm();
		echo " </tr></td>";
	}
	echo "</table>";
?>
