$("[type='checkbox']").bootstrapSwitch();
$('[data-toggle="select"]').select2();
$("#homepage_nav").hide();

const urlfold = window.location.origin+window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/')+1);

$("#send-url").click(() => {
  if ($("#inputurl").val() == "") {
    $("#inputurldiv").addClass("has-error");
  } else {
    $("#loading-send").show();
    $("#error-send").hide();
    $("#send-url").addClass("disabled");

    var mc = ($("#switch-mc").bootstrapSwitch('state')) ? 1 : 0;

    $.post(urlfold+"api/get_file.php", { url: $("#inputurl").val() })
      .done((data, status) => {
        var response = data.split('|');
        $("#loading-send").hide();
        if (status == "success" && response[0] == "DONE") {
          $("#message-send").html("<i class=\"fas fa-check\"></i> The file has been downloaded on the server.");
          $("#analyzing-send").show();

          $.get(urlfold+"api/insert.php", { id: response[1], mc: mc })
            .done((data, status) => {
              var response1 = data.split('|');
              if (response1[0] == "DONE") {
                $("#analyzing-send").hide();
                $("#success-send").html(
                  "<i class=\"fas fa-check\"></i> The file has been analyzed. " +
                  "<a href=\"chart_select.php?id="+response1[1]+"\"><i class=\"fas fa-chart-bar\"></i> Open charts</a>"
                );
              } else if(response1[0] == "ALREADYEXISTS"){
                $("#analyzing-send").hide();
                $("#success-send").html(
                  "<i class=\"fas fa-times\"></i> The file already exists on the server. " +
                  "<a href=\"chart_select.php?id="+response1[1]+"\"><i class=\"fas fa-chart-bar\"></i> Open charts</a>"
                );
              } else {
                $.get(urlfold+"api/insert.php", { id: response[1], mc: mc })
                  .done((data, status) => {
                    var response1 = data.split('|');
                    if (response1[0] == "DONE") {
                      $("#analyzing-send").hide();
                      $("#success-send").html(
                        "<i class=\"fas fa-check\"></i> The file has been analyzed. " +
                        "<a href=\"chart_select.php?id="+response1[1]+"\"><i class=\"fas fa-chart-bar\"></i> Open charts</a>"
                      );
                    } else if(response1[0] == "ALREADYEXISTS"){
                      $("#analyzing-send").hide();
                      $("#success-send").html(
                        "<i class=\"fas fa-times\"></i> The file already exists on the server. " +
                        "<a href=\"chart_select.php?id="+response1[1]+"\"><i class=\"fas fa-chart-bar\"></i> Open charts</a>"
                      );
                    } else {
                      $("#error-send").show();
                      $("#errorcode-send").text("Code: " + response1[1]);
                      $("#send-url").removeClass("disabled");
                    }
                  });
              }
            });

        } else {
          $("#error-send").show();
          $("#errorcode-send").text("Code: " + response[1]);
          $("#send-url").removeClass("disabled");
        }
      });
  }
});

var uploader = new plupload.Uploader({
  runtimes : 'html5,html4',
  browse_button : 'pickfiles',
  container: document.getElementById('uploadercontainer'),
  url : 'api/plupload1.php',
  chunk_size: '8mb',
  multi_selection: false,

  filters : {
    max_file_size : '1000mb',
    mime_types: [
      {title : "CSV files", extensions : "csv"},
      {title : "ZIP files", extensions : "zip"}
    ]
  },

  init: {
    PostInit: function() {
      document.getElementById('uploadfiles').onclick = function() {
        if ($("#telescopename-upload").val() && $("#from-upload").val() && $("#to-upload").val()) {
          uploader.start();
          return false;
        }
      };
    },

    FilesAdded: function(up, files) {
      while (up.files.length > 1) {
        up.removeFile(up.files[0]);
      }
      document.getElementById('filelist').innerHTML = '<small id="' + files[0].id + '">' + files[0].name + ' (' + plupload.formatSize(files[0].size) + ') <b></b></div>';
    },

    UploadProgress: function(up, file) {
      document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
    },

    BeforeUpload: function(up, file) {
      $("#uploadfiles").addClass("disabled");
    },

    FileUploaded: function(up, file, result){
      var response = JSON.parse(result.response);
      if (response.OK == 1) {
        var mc = ($("#mc-upload").bootstrapSwitch('state')) ? 1 : 0;
        $.post(urlfold+"api/uploading.php", { path: response.info.path, telescopio: $("#telescopename-upload").val(), mc: mc, from: $("#from-upload").val(), to: $("#to-upload").val() })
          .done((data, status) => {
            var response1 = data.split('|');
            if (response1[0].includes("ERROR")) {
              $("#error-upload").show();
              $("#errorcode-upload").text("Code: " + response1[1]);
              $("#uploadfiles").removeClass("disabled");
            } else {
              if (response1[0] == "ISNT ZIP") {
                var options = { path: response.info.path, telescopio: $("#telescopename-upload").val(), mc: mc, from: $("#from-upload").val(), to: $("#to-upload").val() };
              } else if (response1[0] == "UNZIPPED") {
                var options = { idzip: response1[1], telescopio: $("#telescopename-upload").val(), mc: mc, from: $("#from-upload").val(), to: $("#to-upload").val() };
              }
              $.get(urlfold+"api/insert.php", options)
                .done((data, status) => {
                  var response2 = data.split('|'); //TODO if error
                  if (response2[0] == "ERROR") {
                    $("#error-upload").show();
                    $("#errorcode-upload").text("Code: " + response1[1]);
                    $("#uploadfiles").removeClass("disabled");
                  } else {
                    $("#success-upload").html(
                      "<i class=\"fas fa-check\"></i> The file has been analyzed. " +
                      "<a href=\"chart_select.php?id="+response2[1]+"\"><i class=\"fas fa-chart-bar\"></i> Open charts</a>"
                    );
                  }
                });
            }
          });
      }
    },

    Error: function(up, err) {
      document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
    }
  }
});

uploader.init();

flatpickr(".flatpickr", {
  maxDate: "today",
  "plugins": [new rangePlugin({ input: "#to-upload"})]
});
