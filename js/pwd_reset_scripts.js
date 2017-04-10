$(document).ready(function() {
    $('#resetForm').submit(function(e) {
        e.preventDefault();
        
        if ($('#password').val() == $('#confirm').val()) {
            this.submit();
        } else {
            $('#msgDiv').html('Error: Passwords do not match.');
            $('#password').focus();
        }
    });
});
