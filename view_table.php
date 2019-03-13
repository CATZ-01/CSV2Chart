<?php
/*											CSV2Chart
						Developed by Filiberto Canino & Francesco Tarantino
		This software is owned by I.I.S. "E. Fermi" of Catanzaro and it is created for EEE Community
			Original source code can be found at following url https://github.com/CATZ-01/CSV2Chart/
											Enjoy it.
*/
if(empty($_GET['id']))
{
	die('ERROR 0:');	
}

include(__DIR__ ."/inc/ssn.php");

include(__DIR__ ."/inc/cfg.php");

include(__DIR__ ."/inc/sql.php");

$seleziona = "SELECT * FROM files WHERE id =  '".$_GET['id']."' ";

if (!$result = $connessione->query($seleziona))
	{
		echo "ERROR 1:";
 		exit();
	}
    else
    {
      	$row = $result->fetch_array(MYSQLI_ASSOC);
    	$path =  $row['path'];
	}

$myfile = fopen($path, "r") or die("ERROR 2:");

$a=0;

echo "<table border=1>";

while(!feof($myfile))
{
	$pieces[$a] = explode(",", fgets($myfile));
    echo "<tr>";
	foreach($pieces[$a] as $key => $value)
    {
  		echo "<td>$value</td>";
	}
    echo "</tr>";
    $a=$a+1;
}
fclose($myfile);
?>