document.getElementById('login').addEventListener('click', function() {
    // Get the values from the form inputs
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    // Validate each field here
    // Example: Check if the firstname is not empty
    if (email.trim() === '' ) {
        alert('Email is required.');
        return;
    }else{
        var atpos = email.indexOf("@");//check if email has @ and the position
        var dotpos = email.lastIndexOf("."); //check if email has . and the last position of it
        if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length) {
            //@ should be at least 1 character before the dot, and the dot should be at least 2 characters from the end of the email
            alert("Not a valid e-mail address (e.g. = you@me.com)");
            return;
        }
    }

   // check if password is valid
    if (password.trim() === '') {
        alert('Password is required.');
        return;
    }
    document.getElementById('login-form').submit();
});

    