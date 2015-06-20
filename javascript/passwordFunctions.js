$(document).ready(function() {
    $("#savePasswordBtn").click(function() {
        if (isPasswordStrong($('#currentPassword').val())) {
            
        }
    });
});

function isPasswordStrong (password) {
    if (password.length > 4) {
        return true;
    }

    return false;
}