$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null) {
       return null;
    }
    return decodeURI(results[1]) || 0;
}

if ($.urlParam('id')) {
  getAvGraph();
} else { //redirect to home
  window.location.replace("home.php");
}

function getAvGraph() {
  $.get(window.location.origin+window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/')+1)+"api/get_headers.php", { id: $.urlParam('id') })
    .done((data, status) => {
      if (status == "success") {
        var allTextLines = data.split(/\n/);
        var details = allTextLines[0].split("|");
        if (details[0] == "ERROR") {
          switch (details[1]) {
            case "1":
              $("#error-loading").text("Invalid ID.");
              break;
            default:
              $("#error-loading").text("There was an error. Please try again.");
              break;
          }
        } else {
          var column = allTextLines[1].split("|");
          if (column.indexOf("Theta") != -1 || column.indexOf("Phi") != -1) {
            $("#div-angles").show();
          }
          if (column.indexOf("Theta") != -1 && column.indexOf("Phi") != -1) {
            $("#div-thetaphi").show();
          }
          if (column.indexOf("Theta") != -1 && column.indexOf("TrackLength") != -1) {
            $("#div-tracktheta").show();
          }
          if (column.indexOf("TrackLength") != -1 && column.indexOf("TimeOfFlight") != -1) {
            $("#div-tt").show();
          }
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
}
