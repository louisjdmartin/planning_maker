<?php
	$liste = $bdd->query("SELECT m_id FROM membres ORDER BY m_nom");
	foreach($liste as $membre){
		$mb = new membre($bdd,$membre['m_id']);
		$mb->actualiseTempsAbs();
		$mb->actualiseTempsPerm();
		
		$last = strtotime($mb->getLastModif());
		if(date("d-m-y") == date("d-m-y", $last)) $affLast = "Aujourd'hui à ".date("h:i", $last);
		else $affLast = date("d-m-Y à h:i");
		
		echo "
			<table>
				<tr>
					<th>".$mb->getNom()."</th>
				</tr> 
				<tr>
					<td>Dernière action: ".$affLast."</td>
				</tr>
				<tr>
					<td>Temps de perm: ";$mb->affichePerm();echo "</td>
				</tr>
				<tr>
					<td>";$mb->afficheAbsence();echo "</td>
				</tr>
				<tr>
					<td>
						<a onclick='modifMbName(".$mb->getId().")'>Modifier </a>
						<a onclick='effMb(".$mb->getId().")'>Effacer</a>
					</td>
				</tr>
			</table>
		";
	}
	echo "
			<table>
				<tr>
					<th>Ajouter</th>
				</tr> 
				<tr>
					<td>
						<a onclick='addMb()'>Ajouter... </a>
					</td>
				</tr>";
			