<?php
/*											CSV2Chart
						Developed by Filiberto Canino & Francesco Tarantino
		This software is owned by I.I.S. "E. Fermi" of Catanzaro and it is created for EEE Community
			Original source code can be found at following url https://github.com/CATZ-01/CSV2Chart/
											Enjoy it.
*/
if(!isset($nomepagina)) $nomepagina="wait";

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
  $ip=$_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
  $ip=$_SERVER['REMOTE_ADDR'];
}

$data = date("Y-m-d H:i:s");

$url = "https://www.catz01.tk/";

$header ='<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	 <meta name="description" content="Free software that analyzes EEE .csv files and generate charts.">
  <meta name="keywords" content="EEE, CATZ01, CSV, Charts, CSV2Chart, Chart, INFN, Centro Fermi, Liceo Fermi, Catanzaro, catz01.tk">
  <meta name="author" content="Filiberto Canino & Francesco Tarantino">	
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-135808253-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag("js", new Date());

  gtag("config", "UA-135808253-1");
</script>
    <title>CSV2Chart - '.$nomepagina.'</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="inc/css/vendor/bootstrap.min.css" rel="stylesheet">
    <link href="inc/css/flat-ui.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<link rel="stylesheet" href="inc/css/main.css">
		<link rel="icon" href="inc/img/favicon.ico" type="image/x-icon" />';

$footer = '<footer class="footer">
      <div class="container">
        <div class="row">
          <div class="col-7">
            <h3 class="footer-title">Extreme Energy Events</h3>
            <p>
              <i class="fas fa-school"></i> School: <a href="http://iisfermi.gov.it"  title="IIS E. Fermi official website">IIS E. Fermi - Catanzaro Lido</a>
              <br />
              <i class="fas fa-envelope-square"></i> Contact us: <a href="mailto:csv2chart@catz01.tk" title="Send us an email">csv2chart@catz01.tk</a>
              <br />
              <i class="fab fa-codepen"></i> V1.0_stable
            </p>
          </div> <!-- /col-7 -->

          <div class="col-5">
            <div class="footer-banner" style="min-height: 0px;">
              <h3 class="footer-title"><i class="fas fa-code"></i> Developers</h3>
              <ul>
                <li><a href="https://www.filibertocanino.it/" target="_blank" title="Filiberto Canino">Filiberto Canino</a></li>
                <li><a href="https://franci22.ml/" target="_blank"  title="Francesco Tarantino">Francesco Tarantino</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>';

if(isset($_SESSION['logged']) && ($_SESSION['logged']== "in")){
  $logout = '<li><a style="color: rgba(255, 255, 255, 0.85);">Logged as '.$_SESSION['uname'].'</a></li><li><a href="logout.php" title="Logout and go homepage"><i class="fas fa-sign-out-alt"></i> Logout</a></li>';
} else {
  $logout = '';
}

$navbar = '<nav class="navbar navbar-inverse navbar-embossed navbar-expand-lg" role="navigation" style="margin-top: 30px;">
              <a class="navbar-brand" href="home.php"  title="CSV2Chart - powered by CATZ-01 students">CSV2Chart</a>
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse-01"></button>
              <div class="collapse navbar-collapse" id="navbar-collapse-01">
              <ul class="nav navbar-nav mr-auto">
                <li id="homepage_nav"><a href="home.php"  title="Go to the homepage"><i class="fas fa-home"></i> Homepage</a></li>
                <li style="display: none;" id="back_btn"><a href="#" onclick="window.history.back();" id="back_btn-a"  title="Go back"><i class="fas fa-arrow-left"></i> Back</a></li>
              </ul>
              <ul class="nav navbar-nav">'.$logout.'</ul>
              </div>
            </nav><!-- /navbar -->';
?>
