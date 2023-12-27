document.getElementById('loginForm').addEventListener('submit', function(event) {
    // Prevent the form from submitting
    event.preventDefault();

    // Get the values from the form inputs
    var email = document.getElementById('loginEmail').value;
    var password = document.getElementById('loginPassword').value;

    // Check if email is valid
    if (email.trim() === '' ) {
        alert('Email is required.');
        return;
    } else {
        var atpos = email.indexOf("@");
        var dotpos = email.lastIndexOf(".");
        if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length) {
            alert("Not a valid e-mail address (e.g. = you@me.com)");
            return;
        }
    }

    // Check if password is valid
    if (password.trim() === '') {
        alert('Password is required.');
        return;
    }

    // If validation passes, submit the form
    event.target.submit();
});