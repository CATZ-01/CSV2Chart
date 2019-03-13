<?php
/*											CSV2Chart
						Developed by Filiberto Canino & Francesco Tarantino
		This software is owned by I.I.S. "E. Fermi" of Catanzaro and it is created for EEE Community
			Original source code can be found at following url https://github.com/CATZ-01/CSV2Chart/
											Enjoy it.
*/
include("../inc/ssn.php");

include("../inc/cfg.php");

if((isset($_POST['path']))&&(isset($_POST['telescopio']))&&(isset($_POST['mc']))&&(isset($_POST['from']))&&(isset($_POST['to'])))
{}
else
{
	echo "ERROR|1";
	exit();
}

if(strpos($_POST['path'], 'zip')===false)
{
	echo "ISNT ZIP";
}
else
{
	$idzip = rand(0,99);
	$zip = new ZipArchive;
	$res = $zip->open($_POST['path']);
	if ($res === TRUE) {
		$zip->extractTo('../zip/'.$idzip.'/');
		$zip->close();
		echo "UNZIPPED|$idzip";
		unlink($_POST['path']);
	} else {
		echo 'ERROR|2';
		unlink($_POST['path']);
	}
}


?>
