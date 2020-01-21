<?php
  $conf = fopen("../includes/jours.json","w");
  $jours = explode(";",$_POST['jours']);


  // Filtre elements vide
  $jours = array_filter($jours, function($value) { return !is_null($value) && $value !== ''; });


  foreach ($jours as $jour) {
    if(!preg_match('/[A-Za-z0-9\/]+/', $jour)){
      die("ERREUR: La saisie ".$jour." n'est pas autorisée !");
    }
  }

  fwrite($conf,json_encode($jours));
  header('location:../?page=jours')
?>
