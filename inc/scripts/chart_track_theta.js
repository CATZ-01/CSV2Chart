$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null) {
       return null;
    }
    return decodeURI(results[1]) || 0;
}

if ($.urlParam('id')) {
  startGraphID();
  $("#back_btn").show();
} else { //redirect to home
  window.location.replace("home.php");
}

function startGraphID() {
  $("#loading_server-p").show();
  var track_length = [];
  var time_of_flight = [];
  var chi = [];
  var theta = [];
  var details;

  $.get(window.location.origin+window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/')+1)+"api/get_data.php", { id: $.urlParam('id'), column: "TrackLength" })
    .done((data, status) => {
      if (status == "success") {
        var allTextLines = data.split(/\n/);
        details = allTextLines[0].split("|");
        if (details[0] == "ERROR") {
          $("#loading_server-p").hide();
          switch (details[1]) {
            case "1":
              $("#error-loading").text("Invalid ID.");
              break;
            case "3":
              $("#error-loading").text("The file does not contain TrackLength column.");
              break;
            default:
              $("#error-loading").text("There was an error. Please try again.");
              break;
          }
        } else {
          for (var i = 1; i < allTextLines.length; i++) {
              track_length.push(allTextLines[i]);
          }

          $.get(window.location.origin+window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/')+1)+"api/get_data.php", { id: $.urlParam('id'), column: "Theta" })
            .done((data, status) => {
              if (status == "success") {
                $("#loading_server-p").hide();
                var allTextLines = data.split(/\n/);
                details = allTextLines[0].split("|");
                if (details[0] == "ERROR") {
                  switch (details[1]) {
                    case "1":
                      $("#error-loading").text("Invalid ID.");
                      break;
                    case "3":
                      $("#error-loading").text("The file does not contain Theta column.");
                      break;
                    default:
                      $("#error-loading").text("There was an error. Please try again.");
                      break;
                  }
                } else {
                  for (var i = 1; i < allTextLines.length; i++) {
                      theta.push(allTextLines[i]);
                  }

                  $.get(window.location.origin+window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/')+1)+"api/get_data.php", { id: $.urlParam('id'), column: "TimeOfFlight" })
                    .done((data, status) => {
                      if (status == "success") {
                        $("#loading_server-p").hide();
                        var allTextLines = data.split(/\n/);
                        details = allTextLines[0].split("|");
                        if (details[0] == "ERROR") {
                          switch (details[1]) {
                            case "1":
                              $("#error-loading").text("Invalid ID.");
                              break;
                            case "3":
                              $("#error-loading").text("The file does not contain TimeOfFlight column.");
                              break;
                            default:
                              $("#error-loading").text("There was an error. Please try again.");
                              break;
                          }
                        } else {
                          for (var i = 1; i < allTextLines.length; i++) {
                              time_of_flight.push(allTextLines[i]);
                          }

                          $.get(window.location.origin+window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/')+1)+"api/get_data.php", { id: $.urlParam('id'), column: "ChiSquare" })
                            .done((data, status) => {
                              if (status == "success") {
                                $("#loading_server-p").hide();
                                var allTextLines = data.split(/\n/);
                                details = allTextLines[0].split("|");
                                if (details[0] != "ERROR") {
                                  for (var i = 1; i < allTextLines.length; i++) {
                                      chi.push(parseFloat(allTextLines[i]));
                                  }
                                }
                                analyzeData(track_length, theta, time_of_flight, chi);

                                var mc = (details[3] == 1) ? " <small>(MC)</small>" : '';
                                $("#csv-details").html(
                                  '<i class="fas fa-satellite-dish"></i> <b>Telescope:</b> '+details[0] + mc +'<br />'+
                                  '<i class="fas fa-calendar-alt"></i> <b>From:</b> '+details[1]+'<br />'+
                                  '<i class="far fa-calendar-alt"></i> <b>To:</b> '+details[2]+'<br />'
                                );
                              } else {
                                console.log("Error"); //TODO: handle error
                              }
                            }
                          );
                        }
                      } else {
                        console.log("Error"); //TODO: handle error
                      }
                    }
                  );
                }
              } else {
                console.log("Error"); //TODO: handle error
              }
            }
          );
        }
      } else {
        console.log("Error"); //TODO: handle error
      }
    }
  );
}

function analyzeData(track_length, theta, time_of_flight, chi) {
  var datat = [];
  var datas = [];

  for (var i = 0; i < theta.length; i++) {
    if (theta[i] > 0 && track_length[i]/time_of_flight[i] < 60 && track_length[i]/time_of_flight[i] > 0 && (chi.length == 0 || chi[i] <= 3)) {
      datat.push([ parseFloat(theta[i]), parseFloat(track_length[i])]);
      datas.push([ parseFloat(theta[i]), track_length[i]/time_of_flight[i]]);
    }
  }

  getChart(datat, datas);
}

function getChart(datat, datas){
  $("#result").show();


  Highcharts.chart('Chart1', {
      chart: {
          zoomType: 'xy',
          height: '100%'
      },
      boost: {
          useGPUTranslations: true,
          usePreAllocated: true
      },
      tooltip: {
          pointFormat:  '<table><tr><td style="padding:0">{point.x}°</td></tr>' +
                        '<tr><td style="padding:0">{point.y} <b>cm</b></td></tr></table>',
          shared: true,
          useHTML: true
      },
      xAxis: {
          gridLineWidth: 1,
          title: {
              text: "Theta"
          }
      },
      yAxis: {
          minPadding: 0,
          maxPadding: 0,
          title: {
              text: "TrackLength (cm)"
          }
      },
      title: {
          text: 'Track length / Theta' //Dare nome appropriato
      },
      series: [{
          type: 'scatter',
          color: 'rgba(152,0,67,0.1)',
          data: datat,
          marker: {
              radius: 1
          },
          name: "Events"
      }]
  });

  Highcharts.chart('Chart2', {
      chart: {
          zoomType: 'xy',
          height: '100%'
      },
      boost: {
          useGPUTranslations: true,
          usePreAllocated: true
      },
      tooltip: {
          pointFormat:  '<table><tr><td style="padding:0">{point.x}°</td></tr>' +
                        '<tr><td style="padding:0">{point.y} <b>cm/ns</b></td></tr></table>',
          shared: true,
          useHTML: true
      },
      xAxis: {
          gridLineWidth: 1,
          title: {
              text: "Theta"
          }
      },
      yAxis: {
          minPadding: 0,
          maxPadding: 0,
          title: {
              text: "Speed (cm/ns)"
          }
      },
      title: {
          text: 'Muons speed / Theta' //Dare nome appropriato
      },
      series: [{
          type: 'scatter',
          color: 'rgba(0,255,0,0.1)',
          data: datas,
          marker: {
              radius: 1
          },
          name: "Events"
      }]
  });
}
