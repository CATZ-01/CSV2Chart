<?php
/*											CSV2Chart
						Developed by Filiberto Canino & Francesco Tarantino
		This software is owned by I.I.S. "E. Fermi" of Catanzaro and it is created for EEE Community
			Original source code can be found at following url https://github.com/CATZ-01/CSV2Chart/
											Enjoy it.
*/
session_start();

if($_SESSION['logged']!="in") {
	header ("Location: index.php?redirect=".urlencode($_SERVER['REQUEST_URI']));
	exit();
}


?>
