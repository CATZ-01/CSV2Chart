<?php
/*											CSV2Chart
						Developed by Filiberto Canino & Francesco Tarantino
		This software is owned by I.I.S. "E. Fermi" of Catanzaro and it is created for EEE Community
			Original source code can be found at following url https://github.com/CATZ-01/CSV2Chart/
											Enjoy it.
*/
if(empty($_GET['id'])) {
	die('ERROR|0');
}

include("../inc/ssn.php");
include("../inc/cfg.php");
include("../inc/sql.php");

$seleziona = "SELECT * FROM files WHERE id =  '".$_GET['id']."' ";
$result = $connessione->query($seleziona);

if ($result->num_rows == 0){
	echo "ERROR|1";
	exit();
} else {
  $row = $result->fetch_array(MYSQLI_ASSOC);
  $path =  $row['path'];
}

$myfile = fopen("../".$path, "r") or die("ERROR|2");

$a = 0;
$id = NULL;

$headers = explode(',', fgets($myfile));
echo $row['telescopio']."|".$row['from_data']."|".$row['to_data']."|".$row['mc']."\n";
foreach($headers as $key => $value){
	echo str_replace("\n", "", $value)."|";
}



fclose($myfile);
?>
