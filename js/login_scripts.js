$(document).ready(function() {    
    if (typeof(Storage) !== "undefined") {
        var persistedPrefs = localStorage.getItem('persistedPrefs');
        if (persistedPrefs !== null) {
            persistedPrefs = JSON.parse(persistedPrefs);

            $('#userName').val(persistedPrefs.userName);
            $('#password').focus();
            $('#rememberMe').prop('checked', true);
        }
    }
    
    $('#loginForm').submit(function(e) {
        e.preventDefault();

        if (typeof(Storage) !== "undefined") {
            if ($('#rememberMe').is(':checked')) {
                var userName = $('#userName').val();
                var prefs = {'userName' : userName };
                localStorage.setItem('persistedPrefs', JSON.stringify(prefs));
            } else {
                localStorage.removeItem('persistedPrefs');
            }
        }
        
        this.submit();
    });
});
