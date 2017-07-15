<?php 


if(isset($_GET['eff']))
{
	$bdd->query("DELETE FROM absences WHERE a_id='".$_GET['eff']."'");
}
if(isset($_POST['m_id_absent']))
{
	$bdd->query("INSERT INTO absences VALUES (NULL, '".date("y-m-d")."', ".$_POST['c_id'].",  ".$_POST['m_id_absent'].", '-')");
}
if(isset($_POST['m_id_remplace']) && $_POST['m_id_remplace']!='NULL')
{
	$bdd->query("INSERT INTO absences VALUES (NULL, '".date("y-m-d")."', ".$_POST['c_id'].",  ".$_POST['m_id_remplace'].", '+')");
}


?>
<form action="?page=absences" method="POST">
	<table>
		<tr><th>Absent</th><th>Remplaçant</th><th>Quand ?</th><th></th></tr><tr><td>
			
			<select name='m_id_absent'>
				<?php
					$membres = $bdd->query("SELECT * FROM membres ORDER BY m_nom");
					foreach($membres as $m){
						echo "<option value='".$m['m_id']."'>".$m['m_nom']."</option>";
					}
				?>
			</select>
			</td><td>
			<select name='m_id_remplace'><option value='NULL'>Personne</option>                                                  
				<?php  
					$membres = $bdd->query("SELECT * FROM membres ORDER BY m_nom");                                                     
					foreach($membres as $m){                                                              
						echo "<option value='".$m['m_id']."'>".$m['m_nom']."</option>";                   
					}                                                                                  
				?>     
			</select>
			</td><td>
			<select name='c_id'>
				<?php
				$cs = $bdd->query('SELECT * FROM creneaux ORDER BY c_jour, c_deb');
				$last_day = -1;
				foreach($cs as $c)
				{
					if($last_day != $c['c_jour']){
						if($last_day != 0)echo "</optgroup>";
						$last_day=$c['c_jour'];
						echo "<optgroup label='".$jours[$c['c_jour']]."'>";

					}
				  echo "<option value='".$c['c_id']."'>".$c['c_deb']." &rarr; ".$c['c_fin']."</option>";
				}

				?>
				<optgroup>
			</select>
		</td><td>
			<input type='submit' value='OK' />
		</tr></td>
		<tr><td colspan='4'><em>L'actualisation du temps d'absence peut ne pas s'afficher de suite</em></td></tr>
	</table>

<table>
	<tr>
		<th>Nom</th>
		<th>Type</th>
		<th>Début</th>
		<th>Fin</th>
		<th>Jour</th>
		<th>Effacer</th>
	</tr>
	<?php
		$absences = $bdd->query('SELECT absences.*, membres.m_nom, creneaux.c_deb, creneaux.c_jour, creneaux.c_fin FROM absences, membres, creneaux WHERE membres.m_id = absences.m_id AND creneaux.c_id = absences.c_id');
		$i=0;
		foreach ($absences as $abs)
		{
			if($abs['a_signe']=='+')	$statut = "RMP";
			else 					$statut = "ABS";
			$i++;
			echo "
				<tr>
					<td>".$abs['m_nom']."</td>
					<td>".$statut."</td>
					<td>".$abs['c_deb']."</td>
					<td>".$abs['c_fin']."</td>
					<td>".$jours[$abs['c_jour']]."</td>
					<td><a href='?page=absences&eff=".$abs['a_id']."'>Effacer</a></td>
				</tr>
			";
		}
		if($i==0)echo "<tr><td colspan='6'>Aucune absences</td></tr>";
		else echo "<tr><td colspan='6'>ABS = Absent; RMP = Remplacement</td></tr>";


	?>
</table>

</form>

