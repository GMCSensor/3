<?php
require ("connessione.php");
if (isset($_POST['tipo'])){
	$tipo=$_POST['tipo'];
}    
if (isset($_POST['marca'])){
	$marca=$_POST['marca'];
}  
if (isset($_POST['array_di_stringhe'])){
	$stringhe_campi=$_POST['array_di_stringhe'];
}  
$array_campi=explode(',',$stringhe_campi);
if (isset($_POST['pattern'])){
	$pattern=$_POST['pattern'];
}  
if (isset($_POST['fk_sensore'])){
	$fk_sensore=$_POST['fk_sensore'];
}  
if (isset($_POST['stringa_errore'])){
	$errore=$_POST['stringa_errore'];
} 
$colonne_tab_rilevazione=mysql_query("SHOW COLUMNS FROM rilevazione");
$field=array();
$i=0;
while($righe=mysql_fetch_assoc($colonne_tab_rilevazione)){
	$field[$i]=$righe["Field"];
    $i++;
}

for ($j=0;$j<count($array_campi);$j++){
	$trovato=false;
    for ($k=0;$k<count($field);$k++){
    	if ($array_campi[$j]==$field[$k]){
        	$trovato=true;
        }
	}
    if ($trovato==false){
    mysql_query("ALTER TABLE rilevazione ADD $array_campi[$j] varchar(30)");
    }
}
if(isset($_POST['submitAdd']))
{
	$ins_tipo=mysql_query("INSERT INTO tipi_sensore (tipo,marca,pattern,array_stringhe,id_sensoreFK,stringa_errore) 
	values ('".$tipo."','".$marca."','".$pattern."','".$stringhe_campi."','".$fk_sensore."','".$errore."')"); //or die(mysql_error());
	if($ins_tipo){
	echo "<script> alert('tipologia sensore aggiunto!'); </script>";
	}
	else{
	echo "<script> alert('tipologia sensore non valido!'); </script>";
	}
}
if($_POST["submitRimuoviTipo"]){

if(isset($_POST["tipo"])&&isset($_POST["marca"])){
$tipo = $_POST["tipo"];
$marca = $_POST["marca"];

if(!rimuoviTipo($tipo,$marca)){
echo "<script> alert('Tipologia di sensore non trovata!'); </script>";
}
else {
echo "<script> alert('Tipologia di sensore rimossa!'); </script>";
}

}
}
if($_POST["submitVisualizzaTipi"]){
	$query = mysql_query("SELECT * FROM tipi_sensore ");
}

function visualizzaTipi(){
	$query = mysql_query("SELECT * FROM tipi_sensore ");
}

function rimuoviTipo($tipo,$marca){
	//se esiste lo elimino
	if(trovaTipo($tipo,$marca)){
		$query = mysql_query("DELETE FROM tipi_sensore WHERE tipo = '".$tipo."' AND marca = '".$marca."' ");
		return true;
	}
	else {
		return false;
	}
}
function trovaTipo($tipo,$marca){
//controllo l'esistenza del tipo e marca
	$query = mysql_query("SELECT * FROM tipi_sensore  WHERE tipo = '".$tipo."' AND marca = '".$marca."' ");
	if(mysql_num_rows($query)>0){
		return true;
	}
	else {
		return false;
	}
}
?>


<!DOCTYPE html>
<html>
<head>
	<link href="stile.css" rel="stylesheet" type="text/css">
	<meta charset="utf-8" />
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<body>




<div id="menu" align="center">
<h2 > Aggiungi tipo sensore </h2>
<h3>Menu</h3>

<div align="center" style="border: solid 2px #ff7738; border-radius:10px;"><br>
<button class="bottone" onclick="window.location.href='gestioneCliente.php'">Gestione clienti</button>
<button class="bottone" onclick="window.location.href='gestioneSensore.php'">Gestione sensori</button>
<button class="bottone" onclick="window.location.href='recuperaDati.php'">Recupera dati</button>
<button class="bottone" onclick="window.location.href='logout.php'">Logout</button>
<br><br>
</div>
<br>



<div id="tipoSensore" align="center">
<form action="tipoSensore.php" method="post">

<input type="text"  name="tipo" class="casella" placeholder="Inserisci tipo">Es. temperatura<br><br>
<input type="text" name="marca" class="casella" placeholder="Inserisci marca">Es. marcaX<br><br>
<input type="text" name="pattern"  class="casella" placeholder="Inserisci pattern sensore">Es. 8,10,4<br><br>
<input type="text" name="array_di_stringhe" class="casella" placeholder="Inserisci campi rilevazione">Es data,ora,rilevazione<br><br>
<input type="text" name="stringa_errore" class="casella" placeholder="Inserisci pattern errore" value="0">Es. 00000000000<br> (Codice di errore utilizzato dal sensore)<br>
<input type="hidden" name="fk_sensore" class="casella" value="-1"><br>
<input type="submit" name="submitAdd" class="bottone"><br>

</form>
</div>
<br>
<form action="tipoSensore.php" method="post">
<input type="submit" class="bottone" value="Visualizza tipologie" name="submitVisualizzaTipi">
</form>
<br>
<div id="visualizza">
<table class="table">

<?php
if($query){
echo"<tr>";
echo"<th class='th'>TIPOLOGIA</th>";
echo"<th class='th'>MARCA</th>";
echo"<th class='th'>PATTERN</th>";
echo"<th class='th'>NOME CAMPI</th>";
echo"<th class='th'>ERRORE</th>";
echo"</tr>";
}

while ($row = mysql_fetch_assoc($query)) {
		echo"<tr>";
        echo "<td class ='td'> ". $row['tipo']."</td> ";
        echo "<td class ='td'> ". $row['marca']." </td>";
        echo "<td class ='td'> ". $row['pattern']." </td> ";
        echo "<td class ='td'> ". $row['array_stringhe']." </td> ";
        echo "<td class ='td'> ". $row['stringa_errore']." </td> ";
        echo "</tr>";
        }

?>
</table>
</div>
<br><br>

<form action="tipoSensore.php" method="post">


<input type="text"  name="tipo" class="casella" placeholder="Inserisci tipologia da eliminare"><br><br>
<input type="text"  name="marca" class="casella" placeholder="Inserisci marca da eliminare"><br><br>
<input type="submit" name="submitRimuoviTipo" class="bottone" value="Rimuovi Tipo">

</form><br><br>
</div><br><br><br>
</body>
</html>