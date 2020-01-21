<?php
	
	
	$page = "defaut";
	if(isset($_GET['reset'])){
		setcookie("m_id", NULL, time(), "/");
		header("location:.");
	}
	if(isset($_GET['choix'])){
		setcookie("m_id", $_GET['choix'], time()+24*3600*365);
		header("location:.");
	}
	
	if(isset($_GET['page']))$page = $_GET['page'];
	if(!isset($_COOKIE['m_id'])){$page = "identification";}
	else {
		$moi = new membre($bdd, $_COOKIE['m_id']);
		if($moi->getId()==0){
			$page = "identification";
			setcookie("m_id", NULL, time(), "/");
		}
		else {
			$moi->actualiseTempsPerm();
			$moi->actualiseTempsAbs();
		}
	}
