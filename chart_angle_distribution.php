<?php

/*											CSV2Chart
						Developed by Filiberto Canino & Francesco Tarantino
		This software is owned by I.I.S. "E. Fermi" of Catanzaro and it is created for EEE Community
			Original source code can be found at following url https://github.com/CATZ-01/CSV2Chart/
											Enjoy it.
*/

$nomepagina="Angle distribution";

include(__DIR__ ."/inc/ssn.php");
include(__DIR__ ."/inc/cfg.php");


echo $header;
?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>
  </head>
  <body>

    <div class="container" id="page">

      <?php echo $navbar; ?>

      <a href="#" class="btn btn-block btn-lg btn-primary" id="selectfilebutton" onclick="$('#csv-input').trigger('click')" style="display: none;"><i class="fas fa-file-import"></i> Select file (.csv)</a><input type="file" id="csv-input" accept=".csv" style="display: none;"/>
      <center>
        <p id="loading_server-p" style="display: none;">Downloading data from server <i class="fas fa-circle-notch fa-spin"></i></p>
        <p id="csv-details"></p>
        <b id="error-loading" style="color: #e74c3c;"></b>
        <div id="angle-select">
        <h5>Select an angle to analyze.</h5>
        <br>
        <select class="form-control select select-primary" data-toggle="select" id="angle" onchange="startGraphID($('#angle').val()); $('#back_btn-a').attr('onclick', 'location.reload();');  $('#back_btn-a').attr('href', '#');" placeholder="Click to select an angle:">
          <option value="" disabled selected>Click to select an angle:</option>
          <option value="Theta">Theta</option>
          <option value="Phi">Phi</option>
        </select>
      </div>

        <p id="loading-p" style="display: none;">Loading <i class="fas fa-circle-notch fa-spin"></i></p>
      </center>
      <div id="result" style="display: none;">
        <canvas id="Chart" width="900" height="400"></canvas>
        <a href="#" id="downloadBtn" class="btn btn-block btn-lg btn-inverse" download="Chart.jpg"><i class="fas fa-download"></i> Download chart</a>
        <h5>Raw data</h5>
        <pre><table id="data"></table></pre>
      </div>

    </div> <!-- /container -->

    <?php echo $footer; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/popper.js@1.14.1/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <!--<script src="https://vjs.zencdn.net/6.6.3/video.js"></script>-->
    <script src="inc/scripts/flat-ui.js"></script>
    <script src="inc/scripts/chart_angle_distribution.js" charset="utf-8"></script>
  </body>
</html>
