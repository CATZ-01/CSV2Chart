<?php
/*											CSV2Chart
						Developed by Filiberto Canino & Francesco Tarantino
		This software is owned by I.I.S. "E. Fermi" of Catanzaro and it is created for EEE Community
			Original source code can be found at following url https://github.com/CATZ-01/CSV2Chart/
											Enjoy it.
*/
require_once("plupload2.php");

$ph = new PluploadHandler(array(
	'target_dir' => '../uploads/',
	'allow_extensions' => 'zip,csv'
));

$ph->sendNoCacheHeaders();
$ph->sendCORSHeaders();

if ($result = $ph->handleUpload()) {
	die(json_encode(array(
		'OK' => 1,
		'info' => $result
	)));
} else {
	die(json_encode(array(
		'OK' => 0,
		'error' => array(
			'code' => $ph->getErrorCode(),
			'message' => $ph->getErrorMessage()
		)
	)));
}
