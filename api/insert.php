<?php
/*											CSV2Chart
						Developed by Filiberto Canino & Francesco Tarantino
		This software is owned by I.I.S. "E. Fermi" of Catanzaro and it is created for EEE Community
			Original source code can be found at following url https://github.com/CATZ-01/CSV2Chart/
											Enjoy it.
*/
include("../inc/ssn.php");

include("../inc/cfg.php");

include("../inc/sql.php");

if(isset($_GET['path']))
	{
		$del_dir= $_GET['path'];
		$tmp_path= $_GET['path'];
		$telescope = $_GET['telescopio'];
		$from_data = $_GET['from'];
		$to_data = $_GET['to'];
	}
	else if(isset($_GET['idzip']))
	{
		$del_dir='../zip/'.$_GET['idzip'].'/';
		$tmp_dir='../zip/'.$_GET['idzip'].'/tmp/';
		$files2 = scandir($tmp_dir, 1);
		$tmp_path= $tmp_dir.$files2[0];
		$telescope = $_GET['telescopio'];
		$from_data = $_GET['from'];
		$to_data = $_GET['to'];
//		echo $del_dir." - ".$tmp_dir." - ".$tmp_path." - ".$telescope." - ".$from_data." - ".$to_data;

	//	exit();
	}
	else
	{
		//exit();
		$del_dir='../zip/'.$_GET['id'].'/';
		$tmp_dir='../zip/'.$_GET['id'].'/tmp/';
		$files2 = scandir($tmp_dir, 1);
		$tmp_path= $tmp_dir.$files2[0];
		$telescopio=explode("from", $files2[0]);
		$telescope = $telescopio[0];
		$da_data=explode("to", $telescopio[1]);
		$from_data = $da_data[0];
		$a_data=explode(".", $da_data[0]);
		$to_data=$a_data[0];
	}


	if(strpos($tmp_path,'csv')===false)
	{
		echo "ERROR|12";
		exit();
	}
$md5file = md5_file($tmp_path);

$inserisci = "INSERT INTO files (telescopio, from_data, to_data, path, mc, ip_autore, data_upload, md5) VALUES ('".$telescope."', '".$from_data."', '".$to_data."', '".$tmp_path."', '".$_GET['mc']."', '".$ip."', '".$data."', '".$md5file."')";

$seleziona = "SELECT * FROM files WHERE md5 = '".$md5file."' ";

if (!$result = $connessione->query($seleziona))
{
	echo "ERROR|1";
	exit();
}
else
{
	if($result->num_rows == 1)
	{
		$row = $result->fetch_array(MYSQLI_ASSOC);
		echo "ALREADYEXISTS|".$row['id'];
		exit();
	}
	else
	{
		if (!$connessione->query($inserisci))
		{
			echo "ERROR|2";
			exit();
		}
		else
		{
			if (!$result = $connessione->query($seleziona))
			{
				echo "ERROR|3";
				exit();
			}
			else
			{
				$row = $result->fetch_array(MYSQLI_ASSOC);
				$idcsv =  $row['id'];
			}
		}
	}

}

$path = "../csv/".$row['id'].".csv";
$db_path = "csv/".$row['id'].".csv";

if (!rename($tmp_path, $path))
{
	echo "ERROR|4";
	exit();
}
else
{
	if($del_dir==$tmp_path)
	{
		unlink($del_dir);
	}else{
		function rmdir_recursive($dir) {
			foreach(scandir($dir) as $file) {
				if ('.' === $file || '..' === $file) continue;
				if (is_dir($dir.'/'.$file)) rmdir_recursive($dir.'/'.$file);
				else unlink($dir.'/'.$file);
			}
			rmdir($dir);
		}
		rmdir_recursive($del_dir);
	}
}

$modifica = "UPDATE files SET path = '".$db_path."'  WHERE id = ".$idcsv;
if (!$connessione->query($modifica))
{
	//echo $modifica."<br>".$connessione->connect_error;
	echo "ERROR|5";
	exit();
}

echo "DONE|$idcsv";
?>
