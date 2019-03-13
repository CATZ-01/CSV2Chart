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

                  analyzeData(track_length, time_of_flight);

                  var mc = (details[3] == 1) ? " <small>(MC)</small>" : '';
                  $("#csv-details").html(
                    '<i class="fas fa-satellite-dish"></i> <b>Telescope:</b> '+details[0] + mc +'<br />'+
                    '<i class="fas fa-calendar-alt"></i> <b>From:</b> '+details[1]+'<br />'+
                    '<i class="far fa-calendar-alt"></i> <b>To:</b> '+details[2]+'<br />'
                  );
                }
              } else {
                console.log("Error"); //TODO: handle error
              }
            }
          );
          $("#downloadBtn").attr("download", details[0]+"from"+details[1]+"to"+details[2]+".png");
        }
      } else {
        console.log("Error"); //TODO: handle error
      }
    }
  );
}

function analyzeData(track_length, time_of_flight) {
  var data = [];

  for (var i = 0; i < time_of_flight.length; i++) {
    if (time_of_flight[i] < 12.5 && time_of_flight[i] > 0) {
      data.push([ parseFloat(time_of_flight[i]), parseFloat(track_length[i])]);
    }
  }

  getChart1(data);

  data = [];
  var count = [];
  var x = [];
  var y = [];
  var z = [];
  var speed = [];
  var temp, c;
  for (var i = 0; i < time_of_flight.length; i++) {
    if (time_of_flight[i] > 0 && time_of_flight[i] < 12.5) {
      temp = parseFloat(track_length[i]).toFixed(1) +","+ parseFloat(time_of_flight[i]).toFixed(1);
      c = data.indexOf(temp);
      if (c == -1) {
        data.push(temp);
        count.push(1);
      } else {
        count[c]++;
      }
    }
  }

  for (var i = 0; i < count.length; i++) {
    if (count[i] == 1) {
      data[i] = "0";
    }
  }

  for (var i = 0; i < data.length; i++) {
    if (data[i] != "0") {
      temp = data[i].split(",");
      x.push(parseFloat(temp[0]));
      y.push(parseFloat(temp[1]));
      z.push(count[i]);
    }
    //result.push([parseInt(temp[0]), parseInt(temp[1]), count[i]]);
  }

  for (var i = 0; i < x.length; i++) {
    if (x[i]/y[i] < 29.9792) {
      speed.push(x[i]/y[i]);
    } else {
      speed.push(0);
    }
  }

  getChart2(x,y,z, speed);
}

var chart;

function getChart1(data){
  $("#result").show();

  chart = Highcharts.chart('Chart1', {
      chart: {
          zoomType: 'xy',
          height: '100%',
      },
      plotOptions: {
          line: {
            marker: {
                enabled: false
            },
            enableMouseTracking: false,
          }
      },
      boost: {
          useGPUTranslations: true,
          usePreAllocated: true
      },
      tooltip: {
          pointFormat:  '<table><tr><td style="padding:0">{point.x} <b>ns</b></td></tr>' +
                        '<tr><td style="padding:0">{point.y} <b>cm</b></td></tr></table>',
          shared: true,
          useHTML: true
      },
      xAxis: {
          min: 0,
          max: 12.5,
          gridLineWidth: 1,
          title: {
              text: "TimeOfFlight (ns)"
          }
      },
      yAxis: {
          //min: 0,
          //max: 200,
          minPadding: 0,
          maxPadding: 0,
          title: {
              text: "TrackLength (cm)"
          }
      },
      title: {
          text: 'Muons speed' //Dare nome appropriato
      },
      legend: {
          enabled: true
      },
      series: [{
          type: 'scatter',
          color: 'rgba(152,0,67,0.1)',
          data: data,
          marker: {
              radius: 1
          },
          name: "Events"
      }]
  });

  addReg(data, Math.round(chart.yAxis[0].dataMin), Math.round(chart.yAxis[0].dataMin)+20);
  addReg(data, Math.round(chart.yAxis[0].dataMin)+20, Math.round(chart.yAxis[0].dataMin)+40);
  addReg(data, Math.round(chart.yAxis[0].dataMin)+40, Math.round(chart.yAxis[0].dataMin)+60);

  chart.addSeries({
      type: 'line',
      data: [[chart.yAxis[0].dataMin/29.9792, chart.yAxis[0].dataMin], [(chart.yAxis[0].dataMin+100)/29.9792, chart.yAxis[0].dataMin+100]],
      name: "Light speed",
      color: 'rgb(40, 255, 40)'
  });

  chart.addSeries({
    type: 'line',
    data: [[0, Math.round(chart.yAxis[0].dataMin)], [12.5, Math.round(chart.yAxis[0].dataMin)]],
    dashStyle: "LongDash",
    color: 'rgb(0,0,0)',
    name: chart.yAxis[0].dataMin,
    lineWidth: 1
  });

  chart.addSeries({
    type: 'line',
    data: [[0, Math.round(chart.yAxis[0].dataMin)+20], [12.5, Math.round(chart.yAxis[0].dataMin)+20]],
    dashStyle: "LongDash",
    color: 'rgb(0,0,0)',
    name: chart.yAxis[0].dataMin+20,
    lineWidth: 1
  });

  chart.addSeries({
    type: 'line',
    data: [[0, Math.round(chart.yAxis[0].dataMin)+40], [12.5, Math.round(chart.yAxis[0].dataMin)+40]],
    dashStyle: "LongDash",
    color: 'rgb(0,0,0)',
    name: chart.yAxis[0].dataMin+40,
    lineWidth: 1
  });

  chart.addSeries({
    type: 'line',
    data: [[0, Math.round(chart.yAxis[0].dataMin)+60], [12.5, Math.round(chart.yAxis[0].dataMin)+60]],
    dashStyle: "LongDash",
    color: 'rgb(0,0,0)',
    name: chart.yAxis[0].dataMin+60,
    lineWidth: 1
  });


  $("#cdet").append("Light speed: <b>29.9792</b> cm/ns<br>");
  $("#cdet").append("Events: <b>"+data.length+"</b>");
}

function addReg(data, min, max) {
  var regression = linearRegression(data, min, max);
  var m = regression.slope, b = regression.intercept;
  var y0 = min,
      x0 = (y0-b)/m;
  var yf = max,
      xf = (yf-b)/m;

  chart.addSeries({
    type: 'line',
    name: 'Speed',
    data: [[x0, y0], [xf, yf]],
    color: 'rgb(255,255,53)'
  });
  $("#cdet").append("Average muons speed ("+min+" < Length < "+max+"): <b>"+m.toFixed(4)+"</b> cm/ns<br>");
}

function linearRegression(data, min, max){
        var lr = {};
        var n = data.length;
        var sum_x = Big(0);
        var sum_y = Big(0);
        var sum_xy = Big(0);
        var sum_xx = Big(0);
        var sum_yy = Big(0);

        for (var i = 0; i < data.length; i++) {
            if (!isNaN(data[i][0]) && data[i][1] > min && data[i][1] < max) {
              sum_x = sum_x.add(data[i][0]);
              sum_y = sum_y.add(data[i][1]);
              sum_xy = sum_xy.add(data[i][0]*data[i][1]);
              sum_xx = sum_xx.add(data[i][0]*data[i][0]);
              sum_yy = sum_yy.add(data[i][1]*data[i][1]);
            }
        }

        lr['slope'] = (n * sum_xy - sum_x * sum_y) / (n*sum_xx - sum_x * sum_x);
        lr['intercept'] = (sum_y - lr.slope * sum_x)/n;
        //lr['r2'] = Math.pow((n*sum_xy - sum_x*sum_y)/Math.sqrt((n*sum_xx-sum_x*sum_x)*(n*sum_yy-sum_y*sum_y)),2);

        return lr;
}

function getChart2(x,y,z,speed){
  var layout = {
    title: 'Track/Time',
    autosize: false,
    width: 1000,
    height: 800,
    scene: {
      xaxis:{title: 'Track', autorange: "reversed"},
      yaxis:{title: 'Time'},
      zaxis:{title: 'Events n.'},
      camera:{
        up: {x:0, y:0, z:1},
        center: {x:0, y:0, z:0},
        eye: {x:2.5, y:0.1, z:0.1}
      }
    },
  };

  var data=[
      {
        type: 'mesh3d',
        x: x,
        y: y,
        z: z,
        intensity: speed,
        colorscale:  [
            [0, 'rgb(220,220,220)'], [0.75, 'rgb(0,60,170)'],
            [0.85, 'rgb(5,255,255)'], [0.9, 'rgb(255,255,0)'],
            [0.95, 'rgb(250,0,0)'], [1, 'rgb(128,0,0)']
        ]
      }
  ];
  Plotly.newPlot('Chart2', data, layout);
}
