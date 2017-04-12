function buildTable(inning, players) {
    var str  = '<h3>Inning ' + inning + '</h3>';
        str += '<table border="1">';
            str += '<thead>';
                str += '<tr>';
                    str += '<th>Position</th>';
                    str += '<th>Player</th>';
                str += '</tr>';
            str += '</thead>';
            str += '<tbody id="inning' + inning + '">';

            for (var player in players) {
                str += "<tr>";
                str += "<td>" + players[player].position  +"</td>";
                str += "<td>" + players[player].playerName + "</td>";
                str += "</tr>";
            }
        str += '</tbody>';
    str += '</table>';
    $('#rosterDiv').append(str);
}

function getRoster(gameId, numberOfInnings) {
    var data = {"game_id" : gameId, "nbr_of_innings" : parseInt(numberOfInnings)};  
    //console.log(data);

    $.ajax({
        url: "generate_roster.php",
        type: "POST",
        dataType: "json",
        data: data,
        error: function(jqXHR, textStatus, errorThrown) {
            // Fatal error on server
        },
        success: function(res){
            //console.log(res);
            var err = res.ERROR;
            if (err) {
                $('#msgDiv').html('Error: ' + err);
            } else {
                var currentInning = 1;
                var players = [];
                var json = JSON.parse(res);
                
                if (json.length == 0) {
                    $('#msgDiv').html('Error: Unable to generate Line-up.');
                } else {
                    $('#inputForm').hide();
                    for (var j in json) {
                        var inning = (json[j].inning);
                        var firstName = (json[j].first_name);
                        var lastName = (json[j].last_name);
                        var playerName = firstName +  " " + lastName;
                        var position = (json[j].name);

                        if (currentInning == inning) {
                           players.push({"playerName" : playerName, "position" : position});
                        } else {
                            buildTable(currentInning, players);
                            currentInning = inning;
                            players = [];
                            players.push({"playerName" : playerName, "position" : position});
                        }
                    }    
                    // push last inning
                    buildTable(currentInning, players);
                }
            }
        }
    });
}

$(document).ready(function() {
  $("#rosterForm").submit(function(e){
    e.preventDefault();
    $('#rosterDiv').html('');  
    $('#msgDiv').html('');
    $nbrOfInnings= $('#nbrOfInnings option:selected').val();

    if ($nbrOfInnings > 0) {
        getRoster(gameId, $nbrOfInnings);
    } else {
        $('#msgDiv').html('Error: Please select the Number of Innings for this Game.');
        $('#nbrOfInnings').focus();
    }
  });
});
