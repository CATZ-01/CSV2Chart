<?php
/*											CSV2Chart
						Developed by Filiberto Canino & Francesco Tarantino
		This software is owned by I.I.S. "E. Fermi" of Catanzaro and it is created for EEE Community
			Original source code can be found at following url https://github.com/CATZ-01/CSV2Chart/
											Enjoy it.
*/

include("../inc/ssn.php");


$idzip = rand(0,99);
$urlzip = trim($_POST['url']);


$curlSES=curl_init();
curl_setopt($curlSES,CURLOPT_URL,$urlzip);
curl_setopt($curlSES,CURLOPT_RETURNTRANSFER,true);
$headers   = array();
$headers[] = 'Cookie: ' . $_SESSION['cookies'][1][0].';'.$_SESSION['cookies'][2][0].';'.$_SESSION['cookies'][3][0];

$fp = fopen('../zip/'.$idzip.'.zip', 'w');
curl_setopt($curlSES, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curlSES,CURLOPT_HEADER, 0);
curl_setopt($curlSES, CURLOPT_POST, 0);
curl_setopt($curlSES, CURLOPT_CONNECTTIMEOUT,100);
curl_setopt($curlSES, CURLOPT_TIMEOUT,300);
curl_setopt($curlSES, CURLOPT_FILE, $fp);
curl_exec($curlSES);
if(curl_error($curlSES)!="") {
  echo curl_error($curlSES);
  //echo "ERROR|1";
  exit;
}

curl_close($curlSES);

//echo $result;

//$fp = fopen('../zip/'.$idzip.'.zip', 'w');
//fwrite($fp, $result);
fclose($fp);
$zip = new ZipArchive;
$res = $zip->open('../zip/'.$idzip.'.zip');
if ($res === TRUE) {
  $zip->extractTo('../zip/'.$idzip.'/');
  $zip->close();
  echo "DONE|$idzip";
  //echo "<a href=insert.php?id=".$idzip."&mc=".$_POST['mc'].">Ho recuperato il file richiesto, clicca per avviare l'elaborazione.</a>";
  unlink('../zip/'.$idzip.'.zip');
} else {
  echo 'ERROR|2';
  unlink('../zip/'.$idzip.'.zip'); //IF THERE IS AN ERROR IN EXTRACTING IT DELETES THE FILE
}

?>
