$(document).ready(function() {  
    var resetSeasonBtn = document.getElementById('resetSeasonBtn');
    if (resetSeasonBtn) {
        $('#resetSeasonBtn').click(function(e){
            e.preventDefault();
            var doReset = confirm('WARNING:\n\nYou are about to clear all data for Coaches, Teams, Players and Games for the current season.\n\nClick "Ok" to reset the season, or "Cancel" to abort.');
            
            if (doReset) {
                var data = {"do_reset" : "true"}; 

                $.ajax({
                    url: "reset_season.php",
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
                            alert('Error: An error has occured and we were unable to reset the season.');
                        } else {
                            alert('Success: The season has been reset.');
                        }
                    }
                });
            }
        });
    }
});
