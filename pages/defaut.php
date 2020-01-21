<?php
	if(date('w')!=0 and $jours == $defaultDays){
		affichePlanning("def", $moi, (date('w')-1));
		echo "<a href='?page=definitif'>Voir planning complet</a>";
	}
	else {
		affichePlanning("def", $moi);
	}
?>
