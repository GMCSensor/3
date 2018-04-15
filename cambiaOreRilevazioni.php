<?php
require ("connessione.php");
$j=1;
for($i=0;$i<=293;$i++){
$j++;
	/*for($i=0;$i<=count($array_campi);$i++){
		if ($array_campi[$i]=="data"){
    		$giorno=rand(1,31);
            $mese=rand(1,12);
            $anno=rand(1990,2017);
            $data=$anno.'-'.$mese.'-'.$giorno;
        }*/
    		$sec=rand(0,59);
            $min=rand(0,59);
            $ora=rand(0,23);
            $tempo=$ora.':'.$min.':'.$sec;
            mysql_query("UPDATE `rilevazione` SET `ora`='".$tempo."' WHERE `id_rilevazione`='".$j."'");
            }
?>