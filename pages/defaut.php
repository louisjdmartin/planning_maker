<?php
	if(date('w')!=0){
		affichePlanning("def", $moi, (date('w')-1));
		echo "<a href='?page=definitif'>Voir planning complet</a>";
	}
	else {
		affichePlanning("def", $moi);
	}
?>
