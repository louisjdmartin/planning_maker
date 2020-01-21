<?php

	$creneaux = $moi->getAllPerm();

	foreach($creneaux as $jour=>$liste_creneaux)
	{
		echo '<table>
				<tr>
					<th colspan="5">'.$jours[$jour].'</th>
				</tr>

				<tr>
				<td>Début</td>
				<td>Fin</td>
				<td>Nb personnes</td>
				<td>Durée</td>
				<td>

				</td>
			</tr>
			';
		foreach($liste_creneaux as $c)
		{
			echo "
				<tr>
					<td><input onchange='modifCreneau(".$c['c_id'].",$jour)' type='text' value='".$c['c_deb']."' id='c_deb_".$c['c_id']."' /></td>
					<td><input onchange='modifCreneau(".$c['c_id'].",$jour)' type='text' value='".$c['c_fin']."' id='c_fin_".$c['c_id']."'/></td>
					<td><input onchange='modifCreneau(".$c['c_id'].",$jour)' min='1'  type='number' value='".$c['maxAffectations']."' id='c_aff_".$c['c_id']."'/></td>
					<td><input onchange='modifCreneau(".$c['c_id'].",$jour)' min='0'  type='number' value='".$c['duree']."' id='c_dur_".$c['c_id']."'/></td>
					<td>
						<a onclick='effCreneau(".$c['c_id'].")'> Effacer </a>
					</td>
				</tr>
			";
		}
		echo "
			<tr>
				<td><input type='text' id='c_deb_add_".$jour."' /></td>
				<td><input type='text' id='c_fin_add_".$jour."' /></td>
				<td><input type='number' min='1' id='c_aff_add_".$jour."' /></td>
				<td><input type='number' min='0' id='c_dur_add_".$jour."' /></td>
				<td>
					<a onclick='addCreneau(".$jour.")'> Ajouter </a>
				</td>
			</tr>
		";
		echo '</table>';
	}



?>
