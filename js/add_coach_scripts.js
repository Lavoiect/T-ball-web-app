$(document).ready(function() {
    $('#addCoachForm').submit(function(e) {
        e.preventDefault();
        
        $teamId= $('#teamName option:selected').val();
        
        if ($teamId > 1) {
            this.submit();
        } else {
            $('#msgDiv').html('Error: Please select a Team.');
            $('#teamName').focus();
        }
    });
});
