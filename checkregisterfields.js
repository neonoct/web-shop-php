function checkregisterfields(formId) {
    var form = document.getElementById(formId);
    if (!form) {
        console.error('Form with ID ' + formId + ' not found.');
        return;
    }
    form.addEventListener('submit', function(event) {
        // Prevent the form from submitting
        event.preventDefault();

        // Get the values from the form inputs
        var firstname = document.getElementById('firstname').value;
        var lastname = document.getElementById('lastname').value;
        var email = document.getElementById('email').value;
        var address = document.getElementById('address').value;
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('confirmPassword').value;

        // Validate each field here
        // Example: Check if the firstname is not empty
        if (firstname.trim() === '' || firstname.length < 2 ) {
            alert('First name is required and should be at least 2 characters long. ');
            return;
        }

        // Continue with other validations...
        // Check lastname, email, address, password, confirmPassword
        if (lastname.trim() === '' || lastname.length < 2) {
            alert('Last name is required and should be at least 2 characters long.');
            return;
        }

        //check if email is valid
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

        //address should also have a space
        if (address.trim() === '') {
            alert('Address is required.');
            return;
        }else if(address.length < 10 || address.indexOf(" ") < 1){
            alert('Not a valid address (e.g. = 1234 Main St)');
            return;
        }

        //password should be at least 8 characters long and should have at least 1 number and 1 special character
        //done using regex otherwise it would be too long
        if (password.trim() === '') {
            alert('Password is required.');
            return;
        }else if(password.length < 8 || !password.match(/^(?=.*[0-9])(?=.*[+-,.!@#$%^&*()=|/`~<>?:;'"\\])[a-zA-Z0-9!@#$%^&*.,+-/()=`~<>?;:'"|\\]+$/)){
            alert('Password should be at least 8 characters long and should have at least 1 number and 1 special character.');
            return;
        }

        // Check if passwords match
        if (password !== confirmPassword) {
            alert('Passwords do not match.');
            return;
        }

        // If all validations pass, submit the form
        this.submit();
    });
}