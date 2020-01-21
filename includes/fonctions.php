<?php
	require dirname(__FILE__) ."/config.conf.php";
	$bdd = new PDO(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
	require dirname(__FILE__) ."/../objets/creneau.php";
	require dirname(__FILE__) ."/../objets/membre.php";
	$version = "1.2.2";

	$conf=null;
	$conf_file=dirname(__FILE__)."/jours.json";

	$defaultDays = array("Lundi","Mardi","Mercredi","Jeudi","Vendredi");

	if(file_exists($conf_file))$conf = fopen($conf_file,'r');
	if($conf)$jours = json_decode(fgets($conf));
	if(!$conf || !$jours){
		$jours = $defaultDays;
		$conf = fopen($conf_file,'a');
		fwrite($conf,json_encode($jours));
	}


	define("NUMBER_OF_DATES", count($jours));


	function compter_perm($mb){
		return $mb->tempsPerm();
	}
	function min_perm($liste_membres, $obj_membres)
	{
		reset($liste_membres);
		$min = current($liste_membres);

		$nb_min_perm = compter_perm($obj_membres[$min]);

		foreach($liste_membres as $mb)
		{
			$perms=compter_perm($obj_membres[$mb]);
			if($perms<$nb_min_perm){
				$min=$mb;
				$nb_min_perm=$perms;
			}
		}
		return $min;
	}
	function genere_planning($bdd)
	{
		$bdd->query("TRUNCATE TABLE planning_temp");
		$obj_membres = array();
		$all = $bdd->query("SELECT m_id FROM membres");
		foreach ($all as $mb){
			$obj_membres[$mb['m_id']]=new membre($bdd,$mb['m_id']);
			$obj_membres[$mb['m_id']]->actualiseTempsAbs();
			$obj_membres[$mb['m_id']]->setTmpAffectation($obj_membres[$mb['m_id']]->tempsAbsence());
		}


		$creneaux = $bdd->query("SELECT c_id,affectations,c_poids FROM creneaux ORDER BY c_poids DESC, RAND()");
		foreach($creneaux as $c)
		{
			$liste_membres = array();
			$membres_dispo = $bdd->query("SELECT m_id FROM dispos WHERE c_id=".$c['c_id']." ORDER BY RAND()");
			foreach($membres_dispo as $mb){
				$liste_membres[] = $mb['m_id'];
			}


			$affecte = array();
			for($i=0;$i<$c['affectations'];$i++)
			{
				$liste_membres = array_diff($liste_membres, $affecte);
				if(count($liste_membres)){
					$member = min_perm($liste_membres, $obj_membres);
					$affecte[] = $member;
					$bdd->query("INSERT INTO planning_temp VALUES (".$c['c_id'].", ".$member.")");
					$obj_membres[$member]->setTmpAffectation($obj_membres[$member]->tempsPerm() + $c['c_poids']);
				}
			}
		}

		if(file_exists (dirname(__FILE__) ."/../phpfiles/last_genere"))unlink(dirname(__FILE__) ."/../phpfiles/last_genere");
		file_put_contents ( dirname(__FILE__) ."/../phpfiles/last_genere" , time() );
	}

  function affichePlanning($p, $moi, $day='ALL')
	{
		global $jours;
		global $bdd;

		if($day=='ALL')$creneaux = $moi->getAllPerm();
		else $creneaux[$day] = $moi->getAllPermByDay($day);
		foreach($creneaux as $jour=>$liste_creneaux)
		{
			echo '<table>
					<tr>
						<th colspan="3">'.$jours[$jour].'</th>
					</tr>
				';
			foreach($liste_creneaux as $c)
			{
				$c_cour = new creneau($bdd, $c['c_id']);
				$affectations = $c_cour->getAffectations($p);

				echo "
					<tr id='ligne_".$c['c_id']."'>
						<td>".$c_cour->getDeb()."</td>
						<td>".$c_cour->getFin()."</td>
						<td>";

							foreach($affectations as $a){
								if($moi->getId() == $a['m_id'])echo "<strong style='background:#f7ff56'>";
								if($p=='temp')echo "<a onclick='modifAffect(".$c['c_id'].",".$a['m_id'].", \"".$a['m_nom']."\")'>";
								echo $a['m_nom']." ";
								if($p=='temp')echo "</a>";
								if($moi->getId() == $a['m_id'])echo "</strong>";
							}

						echo "</td>
					</tr>
				";

			}
			echo '</table>';
		}
	}
