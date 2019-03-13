<?php

/*											CSV2Chart
						Developed by Filiberto Canino & Francesco Tarantino
		This software is owned by I.I.S. "E. Fermi" of Catanzaro and it is created for EEE Community
			Original source code can be found at following url https://github.com/CATZ-01/CSV2Chart/
											Enjoy it.
*/

$result=0;
$pars=array(
  'redir' => '',
	'uname' => $_POST['uname'],
	'upassword' => $_POST['upassword'],
	'remember' => '1',
  'submit' => 'Submit',
);
$curlSES=curl_init();
curl_setopt($curlSES,CURLOPT_URL,"https://iatw.cnaf.infn.it/eee/elog/Query/");
curl_setopt($curlSES,CURLOPT_RETURNTRANSFER,true);
$header_size = curl_getinfo($curlSES, CURLINFO_HEADER_SIZE);
$header = substr($result, 0, $header_size);
curl_setopt($curlSES,CURLOPT_HEADER, 1);
curl_setopt($curlSES, CURLOPT_POST, true);
curl_setopt($curlSES, CURLOPT_POSTFIELDS,$pars);
curl_setopt($curlSES, CURLOPT_CONNECTTIMEOUT,100);
curl_setopt($curlSES, CURLOPT_TIMEOUT,300);
$result=curl_exec($curlSES);
if($result === false)
{
    echo "Errore: ". curl_error($curlSES)." - Codice errore: ".curl_errno($curlSES);
    exit;
}

curl_close($curlSES);



if(strpos($result, "302")== false){
	header ("Location: ../index.php?error");
		//echo $result;
} else {
  $cookies=explode('Set-Cookie:', $result);
  $cookies[1]=explode(';', $cookies[1]);
  $cookies[2]=explode(';', $cookies[2]);
  $cookies[3]=explode(';', $cookies[3]);
  $cookies=str_replace(': ','',$cookies);

  session_start();
  $_SESSION['uname']=$_POST['uname'];
  $_SESSION['upassword']=$_POST['upassword'];
  $_SESSION['logged']="in";
  $_SESSION['cookies']=str_replace(' ','',$cookies);
  if(isset($_GET['redirect']))
  {
	  $redirect = urldecode($_GET['redirect']);
	  header("Location: ..".$redirect);
  }else{
	  header("Location: ../home.php");
  }
}
?>
