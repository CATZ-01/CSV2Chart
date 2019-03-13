<?php
/*											CSV2Chart
						Developed by Filiberto Canino & Francesco Tarantino
		This software is owned by I.I.S. "E. Fermi" of Catanzaro and it is created for EEE Community
			Original source code can be found at following url https://github.com/CATZ-01/CSV2Chart/
											Enjoy it.
*/

$nomepagina="Select a chart";

include(__DIR__ ."/inc/ssn.php");
include(__DIR__ ."/inc/cfg.php");


echo $header;
?>
    <style>
      .imgbtn {
        position: relative;
        text-align: center;
      }
      .imgbtn img {
        width: 100%;
        height: auto;
        filter: blur(6px);
        -webkit-filter: blur(6px);

      }
      .imgbtn .btnp {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        color: white;
        font-size: 16px;
        border: none;
        cursor: pointer;
        text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
      }
      .imgbtn .btnp:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>

    <div class="container" id="page">

      <?php echo $navbar; ?>

      <center>
        <p id="csv-details"></p>
        <b id="error-loading" style="color: #e74c3c;"></b>
      </center>
      <div class="container">
        <div class="row">
          <div class="col-6" id="div-angles" style="display: none;">
            <div class="imgbtn" onmouseover="$('#angledis').css('filter', 'blur(0px)')" onmouseout="$('#angledis').css('filter', 'blur(6px)')">
              <a href="chart_angle_distribution.php?id=<?php echo $_GET['id']; ?>">
                <img src="inc/img/angle.png" id="angledis" title="Open Angle distribution chart">
                <b class="btnp"  title="Open Angle distribution chart">Angle distribution</b>
              </a>
            </div>
          </div>
          <div class="col-6" id="div-tt" style="display: none;">
            <div class="imgbtn" onmouseover="$('#tracktime').css('filter', 'blur(0px)')" onmouseout="$('#tracktime').css('filter', 'blur(6px)')">
              <a href="chart_track_time.php?id=<?php echo $_GET['id']; ?>">
                <img src="inc/img/track_time.jpg" id="tracktime"  title="Open TrackLength/TimeOfFlight charts">
                <b class="btnp" title="Open TrackLength/TimeOfFlight charts">TrackLength/TimeOfFlight</b>
              </a>
            </div>
          </div>
          <div class="col-6" id="div-thetaphi" style="display: none;">
            <div class="imgbtn" onmouseover="$('#thetaphi').css('filter', 'blur(0px)')" onmouseout="$('#thetaphi').css('filter', 'blur(6px)')">
              <a href="chart_theta_phi.php?id=<?php echo $_GET['id']; ?>">
                <img src="inc/img/theta_phi.jpg" id="thetaphi" title="Open Theta/Phi 3D chart">
                <b class="btnp"  title="Open Theta/Phi 3D chart">Theta/Phi (3D)</b>
              </a>
            </div>
          </div>
          <div class="col-6" id="div-tracktheta" style="display: none;">
            <div class="imgbtn" onmouseover="$('#tracktheta').css('filter', 'blur(0px)')" onmouseout="$('#tracktheta').css('filter', 'blur(6px)')">
              <a href="chart_track_theta.php?id=<?php echo $_GET['id']; ?>">
                <img src="inc/img/track_theta.jpg" id="tracktheta" title="Open TrackLength/Theta charts">
                <b class="btnp" title="Open TrackLength/Theta charts">TrackLength/Theta</b>
              </a>
            </div>
          </div>
        </div>
      </div>

    </div> <!-- /container -->

    <?php echo $footer; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/popper.js@1.14.1/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js" charset="utf-8"></script>
    <script src="inc/scripts/flat-ui.js"></script>
    <script src="inc/scripts/chart_select.js"></script>
  </body>
</html>
