<?php
class creneau
{
	private $debut;
	private $fin;
	private $nb_affectations;
	private $liste_affectations;
	private $id_creneau;
	private $tmp_creneau;
	private $bdd;

	
	
	public function  __construct($bd, $c_id)
	{
		$this->bdd = $bd;
		
		if($c_id==0){
			$q = $this->bdd->query("INSERT INTO creneaux VALUES(NULL,'','',0,0,0)");
			$c_id = $this->bdd->lastInsertId();
		}
		
		$infos = $this->bdd->query("SELECT * FROM creneaux WHERE c_id=".$c_id);
		foreach ($infos as $i){
			$this->debut = $i['c_deb'];
			$this->fin   = $i['c_fin'];
			$this->id_creneau   = $i['c_id'];
			$this->tmp_creneau  = $i['c_poids'];
		}
	}

	public function getAffectations($planning) /* = def ou temp */
	{
		$affects = $this->bdd->query("SELECT membres.* FROM planning_".$planning.", membres WHERE membres.m_id = planning_".$planning.".m_id AND c_id=".$this->id_creneau);
		$retour = array();
		foreach ($affects as $a)$retour[] = $a;
		
		return $retour;
	}
	
	public function getDeb() {return $this->debut;}
	public function getFin() {return $this->fin;}

	public function modif($deb,$fin,$jour,$poids,$aff){
		$this->bdd->query("UPDATE `creneaux` SET `c_deb`='$deb',`c_fin`='$fin',`c_jour`='$jour',`c_poids`='$poids',`affectations`='$aff' WHERE `c_id`=".$this->id_creneau);
	}
	
	public function del(){
		$this->bdd->query("DELETE FROM `creneaux`  WHERE `c_id`=".$this->id_creneau);		
	}
	
}