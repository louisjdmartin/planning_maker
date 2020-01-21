<?php
class membre
{
	private $bdd;
	private $nom;
	private $id;
	private $tmp_affectation;
	private $tmp_absences;
	private $last_modif;

	public function __construct($bd, $m_id)
	{
		$this->bdd=$bd;
		$this->id=0;
		$reponse = $this->bdd->query("SELECT * FROM membres WHERE m_id=".$m_id);
		foreach($reponse as $r)
		{
			$this->nom 			= $r['m_nom'];
			$this->id  			= $r['m_id'];
			$this->last_modif	= $r['last_modif'];
		}
		$this->tmp_affectation = 0;
		$this->tmp_absences = 0;
	}

	public function getNom()
	{
		return $this->nom;
	}

	public function setName($n)
	{
		$this->nom=$n;
		$this->bdd->query("UPDATE membres SET m_nom='$n' WHERE m_id=".$this->id);
	}

	public function getId()
	{
		return $this->id;
	}
	public function getLastModif()
	{
		return $this->last_modif;
	}

	public function getAllPermByDay($day) /* Lundi = 0 */
	{
		$retour = array();
		$creneaux = $this->bdd->query("SELECT * FROM creneaux WHERE c_jour=".$day." ORDER BY c_deb");
		foreach($creneaux as $c){
			$dispo=False;
			$d = $this->bdd->query("SELECT m_id FROM dispos WHERE c_id=".$c['c_id']." AND m_id=".$this->id."");
			foreach($d as $i)$dispo=True;

			$retour[] = array(
				"c_id"  => $c['c_id'],
				"c_deb" => $c['c_deb'],
				"c_fin" => $c['c_fin'],
				"duree" => $c['c_poids'],
				"dispo" => $dispo,
				"maxAffectations" => $c['affectations']
			);
		}

		return $retour;
	}

	public function getAllPerm(){
		$retour = array();
		for($i=0;$i<NUMBER_OF_DATES;$i++)
		{
			$retour[] = $this->getAllPermByDay($i);
		}
		return $retour;
	}

	public function setDispo($c_id, $dispo)
	{
		$this->bdd->query('DELETE FROM dispos WHERE c_id='.$c_id.' AND m_id='.$this->id);
		if($dispo=='true')$this->bdd->query('INSERT INTO dispos VALUES('.$c_id.', '.$this->id.')');

		$this->updateModifs();
	}

	public function updateModifs()
	{
		$this->bdd->query("UPDATE membres SET last_modif = NOW() WHERE m_id = '".$this->id."'");
	}

	public function actualiseTempsPerm($planning = "def")
	{
		$a = $this->bdd->query("SELECT c_poids FROM planning_$planning, creneaux WHERE m_id=".$this->id." AND planning_$planning.c_id=creneaux.c_id");
		$i=0;
		foreach($a as $b)$i+=$b['c_poids'];

		$this->tmp_affectation = $i;
	}

	public function tempsPerm()
	{
		return $this->tmp_affectation;
	}

	public function affichePerm()
	{
		$min = $this->tempsPerm();
		$heures = intval(floatval($min)/60.0);
		$min = $min - 60*$heures;
		if($min<10)$min="0".$min;
		echo $heures."h".$min;
	}

	public function actualiseTempsAbs()
	{
		$i=0;
		$b = $this->bdd->query("SELECT absences.c_id, absences.a_signe, creneaux.c_poids FROM absences, creneaux WHERE creneaux.c_id = absences.c_id AND absences.m_id=".$this->id);
		foreach($b as $c){
			if($c['a_signe']=='+')$i+=$c['c_poids'];
			else $i-=$c['c_poids'];
		}
		$this->tmp_absences = $i;
	}
	public function tempsAbsence()
	{
		return $this->tmp_absences;
	}
	public function afficheAbsence()
	{
		$min = $this->tempsAbsence();

		if($min<0) {print "Absent: ";$min=-$min;}
		else if($min>0) print "Remplacement: ";
		else print "Aucune absence, aucun remplacement";

		if($min){
			$heures = intval(floatval($min)/60.0);
			$min = $min - 60*$heures;
			if($min<10)$min="0".$min;
			echo $heures."h".$min;
		}
	}
	public function del()
	{
		$this->bdd->query("DELETE FROM dispos WHERE m_id=".$this->id);
		$this->bdd->query("DELETE FROM absences WHERE m_id=".$this->id);
		$this->bdd->query("DELETE FROM planning_def WHERE m_id=".$this->id);
		$this->bdd->query("DELETE FROM planning_temp WHERE m_id=".$this->id);
		$this->bdd->query("DELETE FROM membres WHERE m_id=".$this->id);
	}
	public function add()
	{
		$q = $this->bdd->query("INSERT INTO membres VALUES(NULL,'','')");
		$this->id = $this->bdd->lastInsertId();
	}

	public function setTmpAffectation($t)
	{
		$this->tmp_affectation = $t;
	}

}
