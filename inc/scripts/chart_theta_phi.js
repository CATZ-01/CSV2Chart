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
  var theta = [];
  var phi = [];
  var details;

  $.get(window.location.origin+window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/')+1)+"api/get_data.php", { id: $.urlParam('id'), column: "Theta" })
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

          $.get(window.location.origin+window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/')+1)+"api/get_data.php", { id: $.urlParam('id'), column: "Phi" })
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
                      $("#error-loading").text("The file does not contain Phi column.");
                      break;
                    default:
                      $("#error-loading").text("There was an error. Please try again.");
                      break;
                  }
                } else {
                  for (var i = 1; i < allTextLines.length; i++) {
                      phi.push(allTextLines[i]);
                  }

                  analyzeData(theta, phi);

                  var mc = (details[3] == 1) ? " <small>(MC)</small>" : '';
                  $("#csv-details").html(
                    '<i class="fas fa-satellite-dish"></i> <b>Telescope:</b> '+details[0] + mc +'<br />'+
                    '<i class="fas fa-calendar-alt"></i> <b>From:</b> '+details[1]+'<br />'+
                    '<i class="far fa-calendar-alt"></i> <b>To:</b> '+details[2]+'<br />'
                  );

                  $("#pre").text("Total events count: " + phi.length);
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


function analyzeData(theta, phi) {
  var data = [];
  var count = [];
  var x = [];
  var y = [];
  var z = [];
  var temp, c;
  for (var i = 0; i < theta.length; i++) {
    temp = Math.ceil(theta[i]) +","+ Math.ceil(phi[i]);
    c = data.indexOf(temp);
    if (c == -1) {
      data.push(temp);
      count.push(1);
    } else {
      count[c]++;
    }
  }

  for (var i = 0; i < data.length; i++) {
    temp = data[i].split(",");
    x.push(parseInt(temp[0]));
    y.push(parseInt(temp[1]));
    z.push(count[i]);
    //result.push([parseInt(temp[0]), parseInt(temp[1]), count[i]]);
  }

  getChart(x,y,z);
}

function getChart(x,y,z){
  $("#result").show();
console.log(x,y,z);
  var layout = {
    title: 'Theta/Phi',
    autosize: false,
    width: 1000,
    height: 800,
    scene: {
      xaxis:{title: 'Theta'},
      yaxis:{title: 'Phi'},
      zaxis:{title: 'Events n.'},
    },
  };

  var data=[
      {
        type: 'mesh3d',
        x: x,
        y: y,
        z: z,
        intensity: z,
        colorscale: 'Jet'
      }
  ];
  Plotly.newPlot('Chart', data, layout);
}
