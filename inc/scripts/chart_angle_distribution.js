$('[data-toggle="select"]').select2();

$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null) {
       return null;
    }
    return decodeURI(results[1]) || 0;
}

if (!$.urlParam('id')) { //redirect to home
  window.location.replace("home.php");
} else {
  $("#back_btn-a").attr("href", "chart_select.php?id="+$.urlParam('id'));
  $("#back_btn").show();
}

function startGraphID(column) {
  $("#loading_server-p").show();
  $("#angle-select").hide();
  var lines = [];
  var details;

  $.get(window.location.origin+window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/')+1)+"api/get_data.php", { id: $.urlParam('id'), column: column })
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
              $("#error-loading").text("The file does not contain the necessary data.");
              break;
            default:
              $("#error-loading").text("There was an error. Please try again.");
              break;
          }
        } else {
          for (var i = 1; i < allTextLines.length; i++) {
              lines.push({ Theta: allTextLines[i] });
          }
          analyzeData(lines, column);
          var mc = (details[3] == 1) ? " <small>(MC)</small>" : '';
          $("#csv-details").html(
            '<i class="fas fa-satellite-dish"></i> <b>Telescope:</b> '+details[0] + mc +'<br />'+
            '<i class="fas fa-calendar-alt"></i> <b>From:</b> '+details[1]+'<br />'+
            '<i class="far fa-calendar-alt"></i> <b>To:</b> '+details[2]+'<br />'
          );
          $("#downloadBtn").attr("download", details[0]+"from"+details[1]+"to"+details[2]+".png");
        }
      } else {
        console.log("Error"); //TODO: handle error
      }
    }
  );
}

function readSingleFile(e) {
  $("#loading-p").show();
  $("#data").empty();
  var file = e.target.files[0];
  $("#csv-details").html('<i class="fas fa-file-csv"></i> '+file.name);
  if (!file) {
    return;
  }
  var reader = new FileReader();
  reader.onload = function(e) {
    var contents = e.target.result;
    analyzeCSV(contents);
  };
  reader.readAsText(file);
}

function analyzeCSV(contents) {

  var allTextLines = contents.split(/\r\n|\n/);
  var headers = allTextLines[0].split(',');
  var lines = [];

  for (var i=1; i<allTextLines.length; i++) {
      var data = allTextLines[i].split(',');
      if (data.length == headers.length) {

          var tarr = {};
          for (var j=0; j<headers.length; j++) {
              tarr[headers[j]] = parseFloat(data[j]);
          }
          lines.push(tarr);
      }
  }

  analyzeData(lines);
  $("#loading-p").hide();
}

function analyzeData(csv, column) {
  if (column == "Theta") {
    var stats = [];
    for (var i = 0; i < 91; i++) {
      stats[i] = 0;
    }
    for (var i = 0; i < csv.length; i++) {
      stats[Math.ceil(csv[i].Theta)]++; //Events
    }

    var i = 90; //Delete Theta with 0 events
    while(stats[i] == 0){
      stats.splice(i, 1);
      i--;
    }
  } else if (column == "Phi"){
    var stats = [];
    for (var i = 0; i < 361; i++) {
      stats[i] = 0;
    }
    for (var i = 0; i < csv.length; i++) {
      stats[Math.ceil(csv[i].Theta)+180]++; //Events
    }
  }
  thetaHistogram(stats, column);
}

function thetaHistogram(stats, column){
  $("#result").show();
  var offset = 0;

  if (column == "Phi") offset = -180;

  var labels = []; //Create table with events
  $("#data").append("<thead><th>Theta (approx.)</th><th>Events</th></thead>");
  for (var i = 0; i < stats.length; i++) {
    $("#data").append("<tr><td>"+(i+offset)+"</td><td>"+stats[i]+"</td></tr>");
    labels[i] = i+offset;
  }

  var ctx = $("#Chart");
  var chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: "Events",
        backgroundColor: "rgba(255, 99, 132, 0.5)",
        data: stats
      }]
    },
    options: {
      animation: {
        onComplete: ()=>{
          var url_base64jp = document.getElementById("Chart").toDataURL("image/png");
          $("#downloadBtn").attr("href", url_base64jp);
        },
        duration: 2000,
        easing: "easeInOutQuart"
      },
      title: {
          display: true,
          text: column + ' distribution',
          fontSize: 24
      }
    }
  });
}

document.getElementById('csv-input')
  .addEventListener('change', readSingleFile, false);
