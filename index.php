<?php 
	//ini_set("display_errors","1");
	require "includes/fonctions.php"; 
	require "includes/ini.php";
?><!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="./assets/style.css" />
		<link rel="stylesheet" href="./assets/animation.css" />
		<script src="https://code.jquery.com/jquery.min.js"></script>
		<script src="./assets/script.js"></script>
		<title>Planning maker V<?php echo $version; ?></title>
		<meta charset="utf-8" />
        <meta name="msapplication-TileColor" content="#F44336"/>
        <meta name="theme-color" content="#F44336">
		<meta name="viewport" content="initial-scale=1.0 maximum-scale=1.0" >


	</head>
	
	<body>
	<?php
		if(!isset($_COOKIE['m_id'])){
			
			include("pages/identification.php");
			
			
		}
		else
		{
			
			?>
				<div id="head_menu">
					<div class="menu-icon arrow isClosed" style="float:left;">
						<svg x="0" y="0" width="54px" height="54px" viewBox="0 0 54 54">
							<circle cx="27" cy="27" r="26"></circle>
						</svg>
						<span></span>
					</div>
					<div id="menu" style="margin-top:18px;margin-bottom:0px;">
						<div class='menu_closed'>
							<strong><?php echo $moi->getNom(); ?></strong> - 
							<a href="./?reset=1">(modifier)</a> - 
							<a href='https://bde.isima.fr/espace_ZZ'>(Retour site BDE)</a>
						</div>
						<div class='menu_open' style="display:none;padding-top:8px;"><br />
							<span><strong>Tâches courantes</strong></span>
							<a href="?page=definitif">Voir le planning definitif</a>
							<a href="?page=dispos">Saisir mes disponibilitées</a>
							<a href="?page=absences">Signaler une absence</a><br /><br />
							
							
							<span><strong>Gestion planning maker</strong></span>
							<a href="?page=temp">Voir le planning temporaire</a>
							<a href="?page=last">Voir le planning de la semaine précédente</a>
							<a href="?page=modifcreneau">Modifier les creneaux</a>
							<a href="?page=membres">Modifier les membres</a>
							<a href="?page=changelog">Changelog</a>
						</div>
					</div>
				</div>
				
				
				<table>
					<tr>
						<td>Temps de permanence cette semaine: <br /><?php $moi->affichePerm(); ?></td>
					</tr>
				</table>
				
				<table>
					<tr>
						<td>Temps d'absence cette semaine: <br /><?php $moi->afficheAbsence(); ?></td>
					</tr>
				</table>

				
				<div id="content">
					<?php include("pages/$page.php"); ?>
				</div>
			<?php 
		} 
	?>
	<div class='version'><em>Planning Maker V<?php echo $version; ?> - Louis Martin</em></div>
	</body>
