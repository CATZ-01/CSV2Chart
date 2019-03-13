<?php
/*											CSV2Chart
						Developed by Filiberto Canino & Francesco Tarantino
		This software is owned by I.I.S. "E. Fermi" of Catanzaro and it is created for EEE Community
			Original source code can be found at following url https://github.com/CATZ-01/CSV2Chart/
											Enjoy it.
*/


//fit this before uploading on yor own server
$host = "	DB HOST	HERE	";
$user = "	DB USER HERE	";
$pass = "	PASS HERE	";
$db = "		DB NAME HERE 	"; 
$connessione = @mysqli_connect($host, $user, $pass, $db) or die(mysqli_connect_error());
?>