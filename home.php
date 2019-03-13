<?php
/*											CSV2Chart
						Developed by Filiberto Canino & Francesco Tarantino
		This software is owned by I.I.S. "E. Fermi" of Catanzaro and it is created for EEE Community
			Original source code can be found at following url https://github.com/CATZ-01/CSV2Chart/
											Enjoy it.
*/
$nomepagina="Home";

include(__DIR__ ."/inc/ssn.php");
include(__DIR__ ."/inc/cfg.php");


echo $header;
?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script type="text/javascript" src="inc/scripts/plupload.js"></script>
  </head>
  <body>

    <div class="container" id="page">

      <?php echo $navbar; ?>

      <div class="container">
        <a href="#" onclick="$('#search_by_t').toggle(500); $('#search_by_t-i').toggleClass('fa-arrow-circle-down fa-arrow-circle-right');" title="Click to expand the area"><h5>Search by telescope <i id="search_by_t-i" class="fas fa-arrow-circle-down"></i></h5></a>
        <div id="search_by_t" style="display:none;">
          <input type="text" id="search" placeholder="Telescope ID" class="form-control"  title="Write to see results" autocomplete="off"/>
          <small><b>Ex:</b> CATZ-01, BOLO-01</small>
          <div id="livesearchdiv"></div>
        </div>
      </div>

      <br>

      <div class="container">
        <a href="#" onclick="$('#send_zip').toggle(500); $('#send_zip-i').toggleClass('fa-arrow-circle-down fa-arrow-circle-right');" title="Click to expand the area"><h5>Send EEE .zip file <i id="send_zip-i" class="fas fa-arrow-circle-down"></i></h5></a>
        <div id="send_zip" style="display:none;">
          <div class="row">
            <div class="col" id="inputurldiv">
              <input type="text" id="inputurl" placeholder="Insert URL" class="form-control">
            </div>
            <div class="col-md-auto">
              <div class="bootstrap-switch-square">
                <label for="switch-mc"  title="Monte Carlo"><b>MC</b></label>
                <input type="checkbox" data-toggle="switch" id="switch-mc" data-on-text="<span class='fui-check'></span>" data-off-text="<span class='fui-cross'></span>" /  title="Monte Carlo">
              </div>
            </div>
          </div>
          <small><b>Ex:</b> https://iatw.cnaf.infn.it/eee/elog/Query/[...]/[...].csv.zip</small>
          <div class="row">
            <div class="col">
              <a href="#" class="btn btn-block btn-lg btn-primary" id="send-url">Send</a>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <p id="loading-send" style="display: none;">Loading <i class="fas fa-circle-notch fa-spin"></i></p>
              <p id="message-send" style="margin: 0;"></p>
              <p id="analyzing-send" style="display: none;">Analyzing <i class="fas fa-circle-notch fa-spin"></i></p>
              <p id="success-send" style="margin: 0;"></p>
              <b id="error-send" style="color: #e74c3c; display: none;">There was a server error during the download. Please try again. <small id="errorcode-send"></small></b>
            </div>
          </div>
        </div>
      </div>

      <br>

      <div class="container" id="uploadercontainer">
        <a href="#" onclick="$('#upload_zip_csv').toggle(500); $('#upload_zip_csv-i').toggleClass('fa-arrow-circle-down fa-arrow-circle-right');" title="Click to expand the area"><h5>Upload .csv or .zip file <i id="upload_zip_csv-i" class="fas fa-arrow-circle-down"></i></h5></a>
        <div id="upload_zip_csv" style="display:none;">
          <div class="row">
            <div class="col-md-auto">
              <b>Telescope ID</b>
            </div>
            <div class="col-md-auto">
              <select class="form-control select select-primary" data-toggle="select" id="telescopename-upload">
                <option value="" selected>Click and select a Telescope
                </option><option value="ALTA-01">ALTA-01
                </option><option value="ANCO-01">ANCO-01
                </option><option value="AREZ-01">AREZ-01
                </option><option value="BARI-01">BARI-01
                </option><option value="BOLO-01">BOLO-01
                </option><option value="BOLO-02">BOLO-02
                </option><option value="BOLO-03">BOLO-03
                </option><option value="BOLO-04">BOLO-04
                </option><option value="CAGL-01">CAGL-01
                </option><option value="CAGL-02">CAGL-02
                </option><option value="CAGL-03">CAGL-03
                </option><option value="CARI-01">CARI-01
                </option><option value="CATA-01">CATA-01
                </option><option value="CATA-02">CATA-02
                </option><option value="CATZ-01">CATZ-01
                </option><option value="CERN-01">CERN-01
                </option><option value="CERN-02">CERN-02
                </option><option value="COSE-01">COSE-01
                </option><option value="FRAS-01">FRAS-01
                </option><option value="FRAS-02">FRAS-02
                </option><option value="FRAS-03">FRAS-03
                </option><option value="GROS-01">GROS-01
                </option><option value="GROS-02">GROS-02
                </option><option value="LAQU-01">LAQU-01
                </option><option value="LAQU-02">LAQU-02
                </option><option value="LECC-01">LECC-01
                </option><option value="LECC-02">LECC-02
                </option><option value="LODI-01">LODI-01
                </option><option value="LODI-02">LODI-02
                </option><option value="PARM-01">PARM-01
                </option><option value="PATE-01">PATE-01
                </option><option value="PISA-01">PISA-01
                </option><option value="POLA-01">POLA-01
                </option><option value="POLA-02">POLA-02
                </option><option value="POLA-03">POLA-03
                </option><option value="REGG-01">REGG-01
                </option><option value="ROMA-01">ROMA-01
                </option><option value="ROMA-02">ROMA-02
                </option><option value="SALE-01">SALE-01
                </option><option value="SALE-02">SALE-02
                </option><option value="SAVO-01">SAVO-01
                </option><option value="SAVO-02">SAVO-02
                </option><option value="SAVO-03">SAVO-03
                </option><option value="SIEN-01">SIEN-01
                </option><option value="SIEN-02">SIEN-02
                </option><option value="TERA-01">TERA-01
                </option><option value="TEST-01">TEST-01
                </option><option value="TORI-01">TORI-01
                </option><option value="TORI-02">TORI-02
                </option><option value="TORI-03">TORI-03
                </option><option value="TORI-04">TORI-04
                </option><option value="TORI-05">TORI-05
                </option><option value="TRAP-01">TRAP-01
                </option><option value="TREV-01">TREV-01
                </option><option value="TRIN-01">TRIN-01
                </option><option value="VIAR-01">VIAR-01
                </option><option value="VIAR-02">VIAR-02
                </option><option value="VICE-01">VICE-01
                </option>
              </select>
            </div>
            <div class="col">
              <div class="bootstrap-switch-square">
                <label for="mc-upload" title="Monte Carlo"><b>MC</b></label>
                <input type="checkbox" title="Monte Carlo" data-toggle="switch" id="mc-upload" data-on-text="<span class='fui-check'></span>" data-off-text="<span class='fui-cross'></span>" />
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-auto">
              <b>Date</b>
            </div>
            <div class="col">
              <input class="flatpickr form-control" type="text" placeholder="From..." style="color: #34495e;" id="from-upload" data-id="rangePlugin">
            </div>
            <div class="col">
              <input class="form-control" type="text" placeholder="To..." style="color: #34495e;" id="to-upload">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col">
              <a href="#" class="btn btn-block btn-lg btn-inverse" id="pickfiles">Select file</a>
            </div>
            <div class="col">
              <a href="#" class="btn btn-block btn-lg btn-success" id="uploadfiles">Upload</a>
            </div>
          </div>
          <small>The file will be uploaded on our server to be stored and processed.</small>
          <div id="filelist"></div>
          <b id="error-upload" style="color: #e74c3c; display: none;">There was a server error. Please try again. <small id="errorcode-upload"></small></b>
          <p id="success-upload" style="margin: 0;"></p>
        </div>
      </div>

    </div> <!-- /container -->

    <br>

		<?php echo $footer; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/popper.js@1.14.1/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js" charset="utf-8"></script>
    <script src="inc/scripts/flat-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/rangePlugin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="inc/scripts/home.js"></script>
    <script type="text/javascript" src="inc/scripts/livesearch.js"></script>
  </body>
</html>
