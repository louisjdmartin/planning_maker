<?php

	$creneaux = $moi->getAllPerm();
	
	foreach($creneaux as $jour=>$liste_creneaux)
	{
		echo '<table>
				<tr>
					<th colspan="3">'.$jours[$jour].'</th>
				</tr> 
			';
		foreach($liste_creneaux as $c)
		{
			echo "
				<tr>
					<td>".$c['c_deb']."</td>
					<td>".$c['c_fin']."</td>
					<td>
						<input onchange='setDispo(".$c['c_id'].")' type='checkbox' name='dispo_".$c['c_id']."' id='dispo_".$c['c_id']."' ".($c['dispo'] ? "checked":"")." />
						<label for='dispo_".$c['c_id']."'>Disponible</label> 
					</td>
				</tr>
			";
		}
		echo '</table>';
	}
	
	
	
?>