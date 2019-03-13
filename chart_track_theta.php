<?php
/*											CSV2Chart
						Developed by Filiberto Canino & Francesco Tarantino
		This software is owned by I.I.S. "E. Fermi" of Catanzaro and it is created for EEE Community
			Original source code can be found at following url https://github.com/CATZ-01/CSV2Chart/
											Enjoy it.
*/

$nomepagina="TrackLength/Theta chart";

include(__DIR__ ."/inc/ssn.php");
include(__DIR__ ."/inc/cfg.php");


echo $header;
?>
    <script type="text/javascript" src="inc/scripts/plupload.js"></script>
  </head>
  <body>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/boost.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
  </head>
  <body>

    <div class="container" id="page">

      <?php echo $navbar; ?>

      <center>
        <p id="loading-p" style="display: none;">Loading <i class="fas fa-circle-notch fa-spin"></i></p>
        <p id="loading_server-p" style="display: none;">Downloading data from server <i class="fas fa-circle-notch fa-spin"></i></p>
        <p id="csv-details"></p>
        <b id="error-loading" style="color: #e74c3c;"></b>
      </center>
      <div id="result" class="row" style="display: none;">
        <div id="Chart1" style="max-width: 700px;" class="col"></div>
        <div id="Chart2" style="max-width: 700px;" class="col"></div>
      </div>

      <br>

    </div> <!-- /container -->

    <?php echo $footer; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/popper.js@1.14.1/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="inc/scripts/flat-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/big.js/5.2.2/big.min.js"></script>
    <script src="inc/scripts/chart_track_theta.js" charset="utf-8"></script>
  </body>
</html>
